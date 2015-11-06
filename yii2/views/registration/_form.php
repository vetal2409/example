<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Registration;
use common\models\Country;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Registration */
/* @var $form yii\widgets\ActiveForm */
/* @var $hotels */
?>

<div class="registration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::hiddenInput('id', $model->id, ['id' => 'without_id']) ?>
    <?= $form->field($model, 'department_id')->textInput(['value' => $model->departmentRel->name, 'disabled' => true, 'id' => 'department_id', 'department_id' => $model->department_id]) ?>

    <?= $form->field($model, 'check_in')->dropDownList(Registration::getCheckIn(), ['prompt' => Yii::t('general', 'Please select'), 'id' => 'check_in', 'disabled' => $model->status !== $model::STATUS_CONFIRM]) ?>

    <?= $form->field($model, 'check_out')->dropDownList(Registration::getCheckOut(), ['prompt' => Yii::t('general', 'Please select'), 'id' => 'check_out', 'disabled' => $model->status !== $model::STATUS_CONFIRM]) ?>

    <?= $form->field($model, 'hotel_id')->dropDownList(ArrayHelper::map($hotels, 'id', 'name'), ['prompt' => Yii::t('general', 'Please select'), 'id' => 'hotel_id', 'disabled' => $model->status !== $model::STATUS_CONFIRM]) ?>

    <?= $form->field($model, 'title')->dropDownList(Registration::getTitles(), ['prompt' => Yii::t('general', 'Please select')]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'department')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'zip')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'country_id')->dropDownList(Country::getMapWithHeader(['Germany']), ['prompt' => Yii::t('general', 'Please select')]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'special_request')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
