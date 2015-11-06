<?php

namespace backend\controllers;

use Yii;
use common\models\Invoice;
use backend\models\InvoiceSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['root']
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
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Invoice();
        if (Yii::$app->request->post('Invoice')) {
            $file = $model->loadFile('excel');
            if ($file->saveAs(Yii::getAlias('@statics/web/' . $file->name))) {
                $invoices = [];
                $objReader = \PHPExcel_IOFactory::load(Yii::getAlias('@statics/web/' . $file->name));
                foreach ($objReader->getActiveSheet()->getRowIterator() as $key => $row) {
                    $activeSheet = $objReader->getActiveSheet();
                    $invoiceModel = Invoice::getByOrderNumber($activeSheet->getCellByColumnAndRow(13, $key)) ?:
                        Invoice::getByRefNumber(0, $row);
                    if ($key !== 1 && $invoiceModel && !array_key_exists($invoiceModel->id, $invoices)) {
                        $invoices[$invoiceModel->id] = $invoiceModel->id;
                        $invoiceModel->setAttributes([
                            'card_organization' => $activeSheet->getCellByColumnAndRow(2, $key)->getValue(),
                            'card_number' => $activeSheet->getCellByColumnAndRow(3, $key)->getValue(),
                            'card_holder' => $activeSheet->getCellByColumnAndRow(4, $key)->getValue(),
                            'base_status' => (int)$activeSheet->getCellByColumnAndRow(9, $key)->getValue(),
                            'amount' => (string)$activeSheet->getCellByColumnAndRow(6, $key)->getValue(),
                            'date_of_receipt' => strtotime($activeSheet->getCellByColumnAndRow(8, $key)->getValue()),
                            'transaction_type' => $activeSheet->getCellByColumnAndRow(11, $key)->getValue(),
                            'job_id' => $activeSheet->getCellByColumnAndRow(13, $key)->getValue()
                        ]);
                        $invoiceModel->save();
                    }
                }
                unset($objReader);
                unlink(Yii::getAlias('@statics/web/' . $file->name));
            }
        }
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
