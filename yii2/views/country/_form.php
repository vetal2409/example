<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'long_name')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'iso2')->textInput(['maxlength' => 2]) ?>

    <?= $form->field($model, 'iso3')->textInput(['maxlength' => 3]) ?>

    <?= $form->field($model, 'numcode')->textInput(['maxlength' => 6]) ?>

    <?= $form->field($model, 'un_member')->dropDownList(['yes' => 'yes', 'no' => 'no'], ['prompt' => Yii::t('general', 'Please select')]) ?>

    <?= $form->field($model, 'calling_code')->textInput(['maxlength' => 8]) ?>

    <?= $form->field($model, 'cctld')->textInput(['maxlength' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
