<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Hotel */
/* @var $roomTypes[] common\models\RoomType */
/* @var $modelHotelRoomTypeMapping common\models\HotelRoomTypeMapping */

$this->title = 'Create Hotel';
$this->params['breadcrumbs'][] = ['label' => 'Hotels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelHotelData' => $modelHotelData,
        'roomTypes' => $roomTypes,
        'countries' => $countries,
        'modelHotelRoomTypeMapping' => $modelHotelRoomTypeMapping,
        'department' => $department,
        'modelHotelDepartmentMapping' => $modelHotelDepartmentMapping,
        'languages' => $languages,
    ]) ?>

</div>
