<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Department */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
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
