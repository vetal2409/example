<?php

namespace backend\controllers;

use common\models\Hotel;
use common\models\HotelRoomTypeMapping;
use Yii;
use common\models\Room;
use backend\models\RoomSearch;
use common\components\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoomController implements the CRUD actions for Room model.
 */
class RoomController extends Controller
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
                        //'actions' => ['index', 'manage'],
                        'allow' => true,
                        'roles' => ['moder']
                    ],
                    [
                        'actions' => ['index'],
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
     * Lists all Room models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Room model.
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
     * Creates a new Room model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Room();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return Url::to(['/room/update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Room model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return Url::to(['/room/update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionManage($hotel_id)
    {
        //$this->allowAccess(Hotel::checkAccess($hotel_id));
        $model = new Room();

        if (Yii::$app->request->post('Room'))
        {

            $data = $_POST['Room'];

            foreach($data['price'] as $key => $roomData)
            {
                $model = new Room();
                $model->setAttribute('hotel_id', $hotel_id);
                $model->setAttribute('room_type_id', $data['room_type_id'][$key]);
                $model->setAttribute('date', strtotime($data['datePicker']));
                $model->setAttribute('allotment', $data['allotment'][$key]);
                $model->setAttribute('price', $data['price'][$key]);
                $model->save();
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('manage', [
                'model' => $model,
            ]);
        }
    }

    public function actionAllotment()
    {
//        $date = strtotime($_POST['date']);
        $this->layout = 'partial';
        $hotelRoomTypes = HotelRoomTypeMapping::getRoomTypeByHotelId($_POST['hotel_id']);
        foreach ($hotelRoomTypes as $hotelRoomType)
        {
            /**
             * @var $room Room
             */
            $room = Room::getByHotelIdAndDateAndRoomTypeId($_POST['hotel_id'], strtotime($_POST['date']), $hotelRoomType->room_type_id);
            $metaData = ['hotel_id' => $_POST['hotel_id'], 'date' => strtotime($_POST['date']), 'room_type_id' => $hotelRoomType->room_type_id];
            if ($room)
            {
                $items[] = [
                    'label' => $hotelRoomType->roomType->name,
                    'content' => $this->render('update', ['model' => $room, 'metaData' => $metaData])
                ];
            } else {
                $items[] = [
                    'label' => $hotelRoomType->roomType->name,
                    'content' => $this->render('create', ['model' => new Room(), 'metaData' => $metaData])
                ];
            }
        }

        return $this->renderPartial('tabs', ['items' => $items]);
    }

//    /**
//     * Deletes an existing Room model.
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
     * Finds the Room model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Room the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Room::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
