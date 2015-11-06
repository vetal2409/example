<?php

namespace backend\controllers;

use common\helpers\MailHelper;
use common\helpers\PdfHelper;
use common\models\Hotel;
use common\models\Invoice;
use common\models\LogRegistration;
use kartik\mpdf\Pdf;
use Yii;
use common\models\Registration;
use backend\models\RegistrationSearch;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegistrationController implements the CRUD actions for Registration model.
 */
class RegistrationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['moder']
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['manager']
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'deleteAdmin' => ['post'],
                    'cancelAdmin' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Registration models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistrationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionHotelRooming()
    {
        /**
         * @var $models Registration[]
         */
        $eventDates = Registration::$eventDates;
        $query = Registration::find()->notDeleted()->with(['hotel', 'country', 'roomType', 'departmentRel'])->andWhere(['status' => Registration::STATUS_CONFIRM])->orderBy('hotel_id'); //->asArray()
        $models = $query->all();
        $data = [];

        foreach ($models as $model) {
            foreach ($eventDates as $key => $time) {
                $model[$key] = $time >= $model['check_in'] && $time < $model['check_out'];
            }
            $parts[$model->hotel_id][] = $model;
        }
        foreach ($parts as $k => $part) {
            $data = array_merge($data, $part);
            $counts = [];
            foreach ($eventDates as $key => $time) {
                $counts[$key] = array_sum(ArrayHelper::getColumn($part, $key));
            }
            $data[] = $counts;
            $data[] = [];
        }

        $dataProvider =  new ArrayDataProvider([
            'allModels' => $data,
        ]);

        return $this->render('hotel-rooming', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Registration model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $invoice = Invoice::getByRegistrationId($model->id);

        if (Yii::$app->request->isPost && Yii::$app->user->checkAccessByRole('moder')) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('view', [
            'model' => $model,
            'invoice' => $invoice
        ]);
    }

    /**
     * Updates an existing Registration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $rooModels = Hotel::getByParams($model->department_id, $model->check_in, $model->check_out, $model->id);
        $hotels = ArrayHelper::getColumn($rooModels, 'hotel');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $logAttributesKeys = ['department_id','hotel_id', 'check_in', 'check_out', 'room_type_id'];
            $logAttributes = $model->getAttributes($logAttributesKeys);
            $logOldAttributes =  $model->getOldAttributes();
            $logStatus = true;
            if (count(array_diff_assoc($logAttributes, $logOldAttributes))) {
                $logRegistration = new LogRegistration();
                $logRegistration->setAttributes($logAttributes);
                $logRegistration->setAttribute('registration_id', $model->id);
                $logRegistration->setAttribute('status', $model->status);
                if ($logRegistration->validate() && $model->setRoomRate()) {
                    $logStatus = $logRegistration->save(false);
                }
            }
            if ($logStatus && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'hotels' => $hotels,
        ]);

    }

    public function action_renderHotelOptions()
    {
        $response = '<option value="">' . Yii::t('general', 'Please select') . '</option>';
        if (Yii::$app->request->isAjax) {
            if (($withoutId = Yii::$app->request->post('withoutId'))
                && ($departmentId = Yii::$app->request->post('departmentId'))
                && ($checkIn = Yii::$app->request->post('checkIn'))
                && ($checkOut = Yii::$app->request->post('checkOut'))
            ) {
                $rooModels = Hotel::getByParams($departmentId, $checkIn, $checkOut, $withoutId);
                $hotels = ArrayHelper::getColumn($rooModels, 'hotel');
                if (count($hotels)) {
                    foreach ($hotels as $hotel) {
                        $response .= '<option value="' . $hotel->id . '">' . $hotel->name . '</option>';
                    }
                }
            }
        }
        return $response;
    }

//    /**
//     * Deletes an existing Registration model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Registration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Registration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Registration::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        if ($model->status === $model::STATUS_CONFIRM) {
            $model->setAttribute('status', $model::STATUS_CANCEL);
            $model->save();

            $invoice = Invoice::getByRegistrationId($id);
            if ($invoice) {
                $invoice->setAttribute('deleted', $model::STATUS_CANCEL);
                $invoice->save();
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->status === $model::STATUS_CONFIRM) {
            $model->setAttribute('status', $model::STATUS_CANCEL);
            $model->setAttribute('deleted', $model::STATUS_DELETED);
            $model->save();

            $invoice = Invoice::getByRegistrationId($id);
            if ($invoice) {
                $invoice->setAttribute('deleted', $model::STATUS_DELETED);
                $invoice->save();
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionCancelAdmin($id)
    {
        $model = $this->findModel($id);
        if ($model && $model->status === $model::STATUS_CONFIRM) {
            $model->setAttribute('status', $model::STATUS_CANCEL);
            $model->save();

            $invoice = Invoice::getByRegistrationId($id);
            if ($invoice) {
                $invoice->setAttribute('deleted', $model::STATUS_CANCEL);
                $invoice->save();
            }
        }
        return $this->redirect(['index']);
    }

    public function actionDeleteAdmin($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            $model->setAttribute('deleted', $model::STATUS_DELETED);
            $model->setAttribute('status', $model::STATUS_CANCEL);
            $model->save();

            $invoice = Invoice::getByRegistrationId($id);
            if ($invoice) {
                $invoice->setAttribute('deleted', $model::STATUS_DELETED);
                $invoice->save();
            }
        }
        return $this->redirect(['index']);
    }

    public function actionResendEmail($id)
    {
        $model = $this->findModel($id);
        $invoice = Invoice::getByRegistrationId($model->id);

        return $this->render('mail', ['model' => $model, 'invoice' => $invoice]);
    }
//
//    public function actionRenderPdf($code)
//    {
//        $model = $this->findModelByCode($code);
//        $invoiceModel = Invoice::getByRegistrationId($model->id);
//        $pdf = new PdfHelper();
//        $invoiceContent = $this->renderPartial('invoice', ['model' => $model, 'invoice' => $invoiceModel]);
//        $pdf->renderPDF($invoiceContent, $model, $invoiceModel);
//        return $this->render('invoice');
//    }

    protected function findModelByCode($code)
    {
        if (($model = Registration::getByCode($code)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $code
     * @throws NotFoundHttpException
     */

    public function actionSendEmail($code)
    {
        /**
         * @var $model Registration
         * @var $invoice Invoice
         */
        $model = $this->findModelByCode($code);
        if ($model->status === $model::STATUS_CONFIRM) {
            $invoice = Invoice::getByRegistrationId($model->id);
            $mail = new MailHelper();
            $pdf = ($invoice && Yii::getAlias('@statics/web/pdfs/' . $invoice->invoice)) ? Yii::getAlias('@statics/web/pdfs/' . $invoice->invoice) : '';
            if ($mail->sendMail($model->getAttribute('email'), Yii::$app->params['adminEmail'], $model, $pdf)) {
                $model->setAttribute('status', Registration::STATUS_CONFIRM);
                if ($model->save() && $invoice !== null) {
                    $invoice->setAttribute('invoice', $pdf);
                    $invoice->save();
                }
                $this->redirect(['view', 'id' => $model->id]);
            };
        }
    }

    public function actionCreateCreditNote($code, $targetBlank = false)
    {
        /**
         * @var $model Registration
         * @var $invoice Invoice
         */
        $model = $this->findModelByCode($code);
        if ($model->status === $model::STATUS_CONFIRM) {
            $invoice = Invoice::getByRegistrationId($model->id);
            $pdfHelper = new PdfHelper();
            $invoice->newAmount = Yii::$app->request->post('Invoice')['newAmount'];
            $invoice->subject = Yii::$app->request->post('Invoice')['subject'];
            $invoice->finalText = Yii::$app->request->post('Invoice')['finalText'];
            $content = $this->renderPartial('credit_note_pdf', ['model' => $model, 'invoice' => $invoice]);
            if ($targetBlank) {
                $pdfHelper->renderPDF($content, $model, $invoice);
            } else {
                $pdfHelper->generatePDF($content, $model, $invoice);
            }
        }
    }


//    public function actionGeneratePdf()
//    {
//        $invoices = Invoice::find()->notDeleted()->with(['registration'])->all();
//        /**
//         * @var $invoices Invoice[]
//         */
//        foreach ($invoices as $invoice) {
//            set_time_limit(30);
//            $path = Yii::getAlias('@statics/web/pdfs/');
//            if ($invoice->invoice !== null && file_exists($path . $invoice->invoice)) {
//                unlink($path . $invoice->invoice);
//            }
//            $pdfHelper = new PdfHelper();
//            $pdfHelper->content = $this->renderPartial('invoice', ['model' => $invoice->registration, 'invoice' => $invoice]);
//            $invoice->invoice = $pdfHelper->generatePDF($pdfHelper->content, null, $invoice);
//            if ($invoice->save()) {
//                echo 'succes : ' . $invoice->registration_id . ' - ' . $invoice->invoice . '<br>';
//            }
//        }
//    }

}
