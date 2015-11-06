<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $userData \common\models\UserData */
/* @var $hotelMapping \common\models\UserHotelMapping */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>
    <?= $form->field($model, 'password')->passwordInput(); ?>
    <?= $form->field($model, 'new_password')->passwordInput(); ?>
    <?= $form->field($model, 'password_repeat')->passwordInput(); ?>
    <div class="form-group">
        <div
            class="col-md-6"><?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' =>'col-md-12 btn btn-success']) ?></div>
        <div
            class="col-md-offset-6"><?= Html::a('Back', Yii::$app->urlManager->createUrl(['/user/update', 'id' => $model->id]), [
                'class' => 'col-md-12 btn btn-primary'
            ]); ?></div>
    </div>
    <?php ActiveForm::end(); ?>

</div>