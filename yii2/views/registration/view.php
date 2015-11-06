<?php

use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use common\models\Invoice;

/* @var $this yii\web\View */
/* @var $model common\models\Registration */
/* @var $invoice Invoice */

$this->title = $model->title . ' ' . $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registrations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?
$this->registerJs('
    $(document).on("click", "#email-modal", function(){
        $("#modal").modal("show");
    });
    $(document).on("click", "#credit-note-modal", function(){
        $("#credit-note").modal("show");
    });
    $(document).on("click", "#show-credit-note", function() {
        var form = $("#credit-note-form");
        form.attr("action", "'.Yii::$app->urlManager->createUrl(["/registration/create-credit-note/", "code" => $model->code, "targetBlank" => true]).'");
        form.attr("target", "_blank");
    });
    $(document).on("click", "#create-credit-note", function() {
        var form = $("#credit-note-form");
        form.attr("action", "'.Yii::$app->urlManager->createUrl(["/registration/create-credit-note/", "code" => $model->code]).'");
        form.removeAttr("target");
    });
    ')
?>

<div class="col-md-offset-4 text-right">
    <?= $model->status === $model::STATUS_CONFIRM ?
        Html::button('Resend email', [
            'class' => 'btn btn-primary',
            'id' => 'email-modal'
        ]) : ''
    ?>
    <?= $model->status === $model::STATUS_CONFIRM ?
        Html::button('Create Credit Note', [
            'class' => 'btn btn-success',
            'id' => 'credit-note-modal'
        ]) : '';
    ?>
    <?= Html::a('Cancel registration',
        Yii::$app->getUrlManager()->createUrl(['registration/delete', 'id' => $model->id]),
        ['class' => 'btn btn-warning']
    ) ?>
    <?= Html::a('Update registration',
        Yii::$app->getUrlManager()->createUrl(['registration/update', 'id' => $model->id]),
        ['class' => 'btn btn-primary']
    ) ?>
    <?= Html::a('Delete registration',
        Yii::$app->getUrlManager()->createUrl(['registration/delete', 'id' => $model->id]),
        ['class' => 'btn btn-danger']
    ) ?>
</div>

<?
$attributes = [
    [
        'attribute' => 'department_id',
        'value' => $model->departmentRel->name,
        'displayOnly' => true
    ],
    [
        'attribute' => 'hotel_id',
        'value' => $model->hotel->name,
        'displayOnly' => true
    ],
    [
        'attribute' => 'check_in',
        'value' => $model->check_in,
        'format' => ['date', 'php:d.m.Y'],
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => $model::getCheckIn()
        ],
        'displayOnly' => true

    ],
    [
        'attribute' => 'check_out',
        'value' => $model->check_out,
        'format' => ['date', 'php:d.m.Y'],
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => $model::getCheckOut()
        ],
        'displayOnly' => true

    ],
    [
        'attribute' => 'room_type_id',
        'value' => $model->roomType->name,
        'displayOnly' => true
    ],
    [
        'attribute' => 'room_rate',
        'value' => $model->generateRoomRate($model->room_rate),
        'format' => 'raw',
        'displayOnly' => true
    ],
    [
        'attribute' => 'status',
        'value' => $model::$reverseStatus[$model->status],
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => $model::$statusNames,
        ],
        'displayOnly' => true
    ],
    [
        'attribute' => 'code',
        'displayOnly' => true
    ],
    [
        'attribute' => 'title',
        'value' => $model->title,
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => $model::getTitles()
        ],
    ],
    'first_name',
    'last_name',
    'company',
    'department',
    'street',
    'zip',
    'city',
    [
        'attribute' => 'country_id',
        'value' => ($model->country) ? $model->country->name : '',
        'type' => DetailView::INPUT_SELECT2,
        'widgetOptions' => [
            'data' => $model->country->getMap()
        ]
    ],
    'email:email',
    'phone',
    [
        'attribute' => 'special_request',
        'type' => DetailView::INPUT_TEXTAREA
    ],
    [
        'attribute' => 'created_at',
        'format' => ['date', 'php:h:i:s A d-m-Y'],
        'displayOnly' => true
    ],
    [
        'attribute' => 'created_by',
        'value' => $model->createdBy ? $model->createdBy->username : null,
        'displayOnly' => true
    ],
    [
        'attribute' => 'updated_at',
        'format' => ['date', 'php:h:i:s A d-m-Y'],
        'displayOnly' => true
    ],
    [
        'attribute' => 'updated_by',
        'value' => $model->updatedBy ? $model->updatedBy->username : null,
        'displayOnly' => true
    ],
];
?>
<div class="registration-view">


    <?= DetailView::widget([
        'model' => $model,
        'mode' => DetailView::MODE_VIEW,

        'buttons1' => Yii::$app->user->checkAccessByRole('moder') ? '{update}' : '',
        'buttons2' => '{view} {save}',

//        'deleteOptions' => [
//            'label' => '<span class="glyphicon glyphicon-ban-circle"></span>',
//            'url' => Url::to(['cancel', 'id' => $model->id]),
//            'title' => 'Cancel',
//
//        ],
//        'viewOptions' => [
//            'title' => 'View',
//
//        ],

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-bed"></i> Registration details</h3>',
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => $attributes
    ])
    ?>

</div>

<?php
Modal::begin([
    'id' => 'modal',
    'header' => '<h2>Email</h2>',
    'closeButton' => false,
    'size' => 'modal-lg'
]);
?>

<?= $this->render('mail', ['model' => $model, 'invoice' => $invoice ?: new Invoice()]) ?>

<?php Modal::end() ?>

<?php
Modal::begin([
    'id' => 'credit-note',
    'header' => '<h2>Credit Note</h2>',
    'closeButton' => false,
    'size' => 'modal-lg'
]);
?>

<?= $this->render('credit_note', ['model' => $model, 'invoice' => $invoice ?: new Invoice()]); ?>

<?php Modal::end() ?>
