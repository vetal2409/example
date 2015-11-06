<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Registration */
/* @var $hotels */
$this->registerJsFile('@web/js/registration/hotel.js', ['depends' => ['yii\web\JqueryAsset']]);

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Registration',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="registration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'hotels' => $hotels,
    ]) ?>

</div>
