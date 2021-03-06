<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RoomType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Room Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-type-view">

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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
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
