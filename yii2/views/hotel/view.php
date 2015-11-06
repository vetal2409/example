<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Hotel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Hotels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hotel-view">

    <div class="col-md-12">
<!--        <div class="col-md-6 text-left image-holder">-->
<!--            --><?//= $model->image->showImage($model->image->id, $model->image->name);?>
<!--        </div>-->
<!--        <div class="col-md-6 text-right">-->
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('Manage rooms', ['/room/manage', 'hotel_id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </p>
<!--        </div>-->
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            //'stars',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => $model->hotelData->description
            ],
            [
                'attribute' => 'location',
                'format' => 'raw',
                'value' => $model->hotelData->location
            ],
            [
                'attribute' => 'price_information',
                'format' => 'raw',
                'value' => $model->hotelData->price_information
            ],
            [
                'attribute' => 'other',
                'format' => 'raw',
                'value' => $model->hotelData->other
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:h:i:s A d-m-Y']
            ],
            [
                'attribute' => 'created_by',
                'value' => $model->createdBy ? $model->createdBy->username : null
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:h:i:s A d-m-Y']
            ],
            [
                'attribute' => 'updated_by',
                'value' => $model->updatedBy ? $model->updatedBy->username : null
            ],
        ],
    ]) ?>

</div>
