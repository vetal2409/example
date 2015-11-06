<?
/**
 * @var $model Registration
 * @var $invoice Invoice
 */

use common\models\Registration;
use common\models\Invoice;
use kartik\form\ActiveForm;
use vova07\imperavi\Widget;
use kartik\helpers\Html;

?>

<?php
$form = ActiveForm::begin([
    'id' => 'credit-note-form',
    'action' => Yii::$app->urlManager->createUrl(['/registration/create-credit-note/', 'code' => $model->code]),
    'options' => [
        'target' => '_blank'
    ]
]);
?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($invoice, 'newAmount')->textInput() ?>

            <?= Html::label('Subject', 'Invoice[subject]') ?>
            <?= Widget::widget([
                'name' => 'Invoice[subject]',
                'value' => $invoice->subject,
                'settings' => [
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                    ]
                ]
            ]);
            ?>

            <?= Html::label('Final Text', 'Invoice[finalText]') ?>
            <?= Widget::widget([
                'name' => 'Invoice[finalText]',
                'value' => $invoice->finalText,
                'settings' => [
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                    ]
                ]
            ]);
            ?>
            <div class="col-md-offset-6 text-right">
                <?= Html::submitButton('Show Template', ['class' => 'btn btn-primary', 'id' => 'show-credit-note']) ?>
                <?= Html::submitButton('Create credit note', ['class' => 'btn btn-success', 'id' => 'create-credit-note']) ?>
            </div>
        </div>
    </div>

<?php $form->end() ?>