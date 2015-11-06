<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $userData \common\models\UserData */
/* @var $hotelMapping \common\models\UserHotelMapping */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'User',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userData' => $userData,
        //'hotelMapping' => $hotelMapping,
    ]) ?>

</div>
