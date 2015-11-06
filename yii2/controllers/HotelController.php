<?php

namespace backend\controllers;

use common\components\ActiveRecord;
use common\models\City;
use common\models\Country;
use common\models\Department;
use common\models\HotelData;
use common\models\HotelDepartmentMapping;
use common\models\HotelRoomTypeMapping;
use common\models\Image;
use common\models\Lang;
use common\models\RoomType;
use Yii;
use common\models\Hotel;
use backend\models\HotelSearch;
use common\components\Controller;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HotelController implements the CRUD actions for Hotel model.
 */
class HotelController extends Controller
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
                        'actions' => ['update'],
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
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Hotel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HotelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        //$this->allowAccess(Hotel::checkAccess($id));
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Hotel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Hotel();
        $modelHotelData = new HotelData();
        $languages = Lang::getAll();
        $roomTypes = RoomType::getRoomTypes();
        $countries = Country::getAllCountries();
        $savePath = Yii::getAlias($model::FILE_PATH);
        $department = Department::getAll();
        $modelHotelDepartmentMapping = new HotelDepartmentMapping();
        $modelHotelRoomTypeMapping = new HotelRoomTypeMapping();

        if ($model->load(Yii::$app->request->post())) {
//            $modelCity = City::getOrCreateByNameAndCountryId($_POST['Hotel']['cityName'], $model->country_id);
//            $model->city_id = $modelCity->id;
            if ($model->save()) {
                foreach ($_POST['HotelRoomTypeMapping']['room_type_id'] as $roomTypeId) {
                    $modelHotelRoomTypeMapping = new HotelRoomTypeMapping();
                    $modelHotelRoomTypeMapping->setAttribute('hotel_id', $model->getAttribute('id'));
                    $modelHotelRoomTypeMapping->setAttribute('room_type_id', $roomTypeId);
                    $modelHotelRoomTypeMapping->save();
                }

                foreach ($_POST['HotelDepartmentMapping']['department_id'] as $departmentId) {
                    $modelHotelDepartmentMapping = new HotelDepartmentMapping();
                    $modelHotelDepartmentMapping->setAttribute('hotel_id', $model->getAttribute('id'));
                    $modelHotelDepartmentMapping->setAttribute('department_id', $departmentId);
                    $modelHotelDepartmentMapping->save();
                }


                foreach ($languages as $key => $language) {
                    $modelHotelData = new HotelData();
                    $modelHotelData->setAttribute('hotel_id', $model->id);
                    $modelHotelData->setAttribute('lang_id', Yii::$app->request->post('HotelData')['lang_id'][$key]);
                    $modelHotelData->setAttribute('description', Yii::$app->request->post('HotelData')['description'][$key]);
                    $modelHotelData->setAttribute('location', Yii::$app->request->post('HotelData')['location'][$key]);
                    $modelHotelData->setAttribute('price_information', Yii::$app->request->post('HotelData')['price_information'][$key]);
                    $modelHotelData->setAttribute('other', Yii::$app->request->post('HotelData')['other'][$key]);
                    $modelHotelData->save();
                }


                $files = $model->loadFiles($model->fileAttribute);
                if (count($files) !== 0) {
                    foreach ($files as $file) {
                        if ($file->saveAs($savePath . $file->name)) {
                            $image = new Image();
                            $image->setAttribute('name', $file->name);
                            $image->setAttribute('hotel_id', $model->id);
                            $image->setAttribute('path', $model::FILE_PATH . $file->name);
                            $image->save();
                        }
                    }
                }

                $model->setAttribute('preview_image_id', (!empty($image) ? $image->id : $model::IMAGE_NOT_SET));
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//
//        }
        return $this->render('create', [
            'model' => $model,
            'modelHotelData' => $modelHotelData,
            'countries' => $countries,
            'roomTypes' => $roomTypes,
            'modelHotelRoomTypeMapping' => $modelHotelRoomTypeMapping,
            'department' => $department,
            'modelHotelDepartmentMapping' => $modelHotelDepartmentMapping,
            'languages' => $languages,
        ]);
    }

    /**
     * Updates an existing Hotel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //$this->allowAccess(Hotel::checkAccess($id));
        $model = $this->findModel($id);
        $languages = Lang::getAll();
        $roomTypes = RoomType::getRoomTypes();
        $department = Department::getAll();
        $modelHotelDepartmentMapping = new HotelDepartmentMapping();
        $modelHotelData = HotelData::getByHotelId($id);
        if (!$modelHotelData) {
            $modelHotelData = new HotelData();
        }
        $availableRooms = HotelRoomTypeMapping::getRoomTypesIdByHotelId($id);
        $hotelDepartments = HotelDepartmentMapping::getByHotelId($id);
        $modelHotelRoomTypeMapping = new HotelRoomTypeMapping();
        $countries = Country::getAllCountries();
        $savePath = Yii::getAlias($model::FILE_PATH);
        $imageDataProvider = new ArrayDataProvider([
            'models' => Image::getImagesByHotelId($id)
        ]);

        if ($model->load(Yii::$app->request->post())) {

//            $modelCity = City::getOrCreateByNameAndCountryId($_POST['Hotel']['cityName'], $model->country_id);
//            $model->city_id = $modelCity->id;
            if ($model->save()) {
                foreach ($_POST['HotelRoomTypeMapping']['room_type_id'] as $roomTypeId) {
                    $hotelRoomTypeMappings = HotelRoomTypeMapping::getRoomTypeByHotelIdAndRoomTypeId($id, $roomTypeId);
                    if (!$hotelRoomTypeMappings) {
                        $modelHotelRoomTypeMapping = new HotelRoomTypeMapping();
                        $modelHotelRoomTypeMapping->setAttribute('hotel_id', $model->getAttribute('id'));
                        $modelHotelRoomTypeMapping->setAttribute('room_type_id', $roomTypeId);
                        $modelHotelRoomTypeMapping->save();
                    } elseif ($hotelRoomTypeMappings->getAttribute('deleted') === ActiveRecord::STATUS_DELETED) {
                        $hotelRoomTypeMappings->setAttribute('deleted', ActiveRecord::STATUS_NOT_DELETED);
                        $hotelRoomTypeMappings->save();
                    }
                }

                foreach ($languages as $key => $language) {
                    $modelHotelData = HotelData::getByLanguageIdAndHotelId($language->local, $id);
                    if ($modelHotelData) {
                        $modelHotelData->setAttribute('lang_id', Yii::$app->request->post('HotelData')['lang_id'][$key]);
                        $modelHotelData->setAttribute('description', Yii::$app->request->post('HotelData')['description'][$key]);
                        $modelHotelData->setAttribute('location', Yii::$app->request->post('HotelData')['location'][$key]);
                        $modelHotelData->setAttribute('price_information', Yii::$app->request->post('HotelData')['price_information'][$key]);
                        $modelHotelData->setAttribute('other', Yii::$app->request->post('HotelData')['other'][$key]);
                        $modelHotelData->save();
                    } else {
                        $modelHotelData = new HotelData();
                        $modelHotelData->setAttribute('hotel_id', $id);
                        $modelHotelData->setAttribute('lang_id', Yii::$app->request->post('HotelData')['lang_id'][$key]);
                        $modelHotelData->setAttribute('description', Yii::$app->request->post('HotelData')['description'][$key]);
                        $modelHotelData->setAttribute('location', Yii::$app->request->post('HotelData')['location'][$key]);
                        $modelHotelData->setAttribute('price_information', Yii::$app->request->post('HotelData')['price_information'][$key]);
                        $modelHotelData->setAttribute('other', Yii::$app->request->post('HotelData')['other'][$key]);
                        $modelHotelData->save();
                    }
                }

                foreach ($availableRooms as $room) {
                    if (!in_array($room, $_POST['HotelRoomTypeMapping']['room_type_id'])) {
                        $hotelRoomTypeMapping = HotelRoomTypeMapping::getRoomTypeByHotelIdAndRoomTypeId($id, $room);
                        $hotelRoomTypeMapping->setAttribute('deleted', ActiveRecord::STATUS_DELETED);
                        $hotelRoomTypeMapping->save();
                    }
                }

                foreach ($_POST['HotelDepartmentMapping']['department_id'] as $departmentId) {
                    $hotelDepartmentMapping = HotelDepartmentMapping::getByHotelIdAndDepartmentId($id, $departmentId);
                    if (!$hotelDepartmentMapping) {
                        $modelHotelDepartmentMapping = new HotelDepartmentMapping();
                        $modelHotelDepartmentMapping->setAttribute('hotel_id', $model->getAttribute('id'));
                        $modelHotelDepartmentMapping->setAttribute('department_id', $departmentId);
                        $modelHotelDepartmentMapping->save();
                    } elseif ($hotelDepartmentMapping->getAttribute('deleted') === ActiveRecord::STATUS_DELETED) {
                        $hotelDepartmentMapping->setAttribute('deleted', ActiveRecord::STATUS_NOT_DELETED);
                        $hotelDepartmentMapping->save();
                    }
                }

                foreach ($hotelDepartments as $department) {
                    if (!in_array($department, $_POST['HotelDepartmentMapping']['department_id'])) {
                        $modelHotelDepartmentMapping = HotelDepartmentMapping::getByHotelIdAndDepartmentId($id, $department);
                        $modelHotelDepartmentMapping->setAttribute('deleted', ActiveRecord::STATUS_DELETED);
                        $modelHotelDepartmentMapping->save();
                    }
                }


                $files = $model->loadFiles($model->fileAttribute);
                if ($files !== false) {
                    foreach ($files as $file) {
                        if ($file->saveAs($savePath . $file->name)) {
                            $image = new Image();
                            $image->setAttribute('name', $file->name);
                            $image->setAttribute('hotel_id', $id);
                            $image->setAttribute('path', $model::FILE_PATH . $file->name);
                            $image->save();
                        }
                    }
                }

                if ($model->preview_image_id === 0 || $model->preview_image_id === null) {
                    $model->setAttribute('preview_image_id', (!empty($image) ? $image->id : $model::IMAGE_NOT_SET));
                    $model->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelHotelData' => $modelHotelData,
            'modelHotelRoomTypeMapping' => $modelHotelRoomTypeMapping,
            'roomTypes' => $roomTypes,
            'countries' => $countries,
            'availableRooms' => $availableRooms,
            'hotelDepartments' => $hotelDepartments,
            'imageDataProvider' => $imageDataProvider,
            'department' => $department,
            'modelHotelDepartmentMapping' => $modelHotelDepartmentMapping,
            'languages' => $languages,
        ]);
    }

    /**
     * Deletes an existing Hotel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->allowAccess(Hotel::checkAccess($id));
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Hotel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hotel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hotel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSetPreviewImage()
    {
        if (Yii::$app->request->post('hotel_id') && Yii::$app->request->post('image_id')) {
            $modelHotel = $this->findModel(Yii::$app->request->post('hotel_id'));
            $modelHotel->setAttribute('preview_image_id', Yii::$app->request->post('image_id'));
            $modelHotel->save();
        };
    }

    public function actionDeleteImage()
    {
        if (Yii::$app->request->post('image_id')) {
            $modelImage = Image::getById(Yii::$app->request->post('image_id'));
            $modelImage->delete();
        }
    }
}
