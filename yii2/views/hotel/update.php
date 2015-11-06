<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Hotel */
/* @var $imageDataProvider common\models\Image */
/* @var $availableRooms array() */
/* @var $modelHotelRoomTypeMapping common\models\HotelRoomTypeMapping */
/* @var $roomTypes[] common\models\RoomType */

$this->title = 'Update Hotel: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Hotels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hotel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelHotelData' => $modelHotelData,
        'modelHotelRoomTypeMapping' => $modelHotelRoomTypeMapping,
        'roomTypes' => $roomTypes,
        'countries' => $countries,
        'availableRooms' => $availableRooms,
        'imageDataProvider' => $imageDataProvider,
        'department' => $department,
        'modelHotelDepartmentMapping' => $modelHotelDepartmentMapping,
        'hotelDepartments' => $hotelDepartments,
        'languages' => $languages,
    ]) ?>
</div>
