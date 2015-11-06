<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Room */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$uniqid = uniqid();
$this->registerJs(
    "$('#manage-room$uniqid').on('beforeSubmit', function(event, jqXHR, settings) {
                var form = $(this);
                if(form.find('.has-error').length) {
                        return false;
                }

                $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(data) {
                            var button = $('#button-$uniqid');
                            if (button.hasClass('btn btn-success'))
                                {
                                    button.attr('class', 'btn btn-primary');
                                    button.attr('value', 'Update');
                                    button.text('Update');
                                }
                            form.attr('action', data)
                            }
                });

                return false;
        }),"
)
?>

<div class="room-form">

    <?php $form = ActiveForm::begin([
        'action' => ($model->isNewRecord) ? ['create'] : ['update', 'id' => $model->id],
        'enableClientValidation' => true,
        'id' => 'manage-room' . $uniqid,
    ]); ?>

    <?= $form->field($model, 'hotel_id')->hiddenInput(['value' => $metaData['hotel_id']])->label(false) ?>

    <?= $form->field($model, 'room_type_id')->hiddenInput(['value' => $metaData['room_type_id']])->label(false) ?>

    <?= $form->field($model, 'date')->hiddenInput(['value' => $metaData['date']])->label(false) ?>

    <?= $form->field($model, 'allotment')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'id' => 'button-'.$uniqid
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
