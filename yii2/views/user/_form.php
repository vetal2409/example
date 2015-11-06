<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Role;
use common\models\Hotel;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $userData \common\models\UserData */
/* @var $hotelMapping \common\models\UserHotelMapping */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($userData, 'first_name') ?>
    <?= $form->field($userData, 'last_name') ?>
    <?php if ($model->isNewRecord) {
        echo $form->field($model, 'password')->passwordInput();
        echo $form->field($model, 'password_repeat')->passwordInput();
    } ?>
    <?= $form->field($model, 'role')->dropDownList(Role::getChildren(), ['prompt' => Yii::t('general', 'Please select')]) ?>
    <? //= $form->field($hotelMapping, 'hotel_id')->dropDownList(Hotel::getMap(), ['prompt' => Yii::t('general', 'Please select')]) ?>
    <div class="form-group">
        <div
            class="col-md-6"><?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'col-md-12 btn btn-success' : 'col-md-12 btn btn-primary']) ?></div>
        <div
            class="col-md-offset-6"><?= Html::a('Change password', Yii::$app->urlManager->createUrl(['/user/change-password', 'id' => $model->id]), [
                'class' => 'col-md-12 btn btn-danger'
            ]); ?></div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
