<?php

use yii\helpers\Html;
use common\components\GridView;
use common\models\Invoice;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Invoices');
//$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="row">-->
<!--        --><?php //$form = ActiveForm::begin([
//            'options' => ['enctype' => 'multipart/form-data'],
//        ]); ?>
<!--        --><?//= $form->field($model, 'excel')->fileInput(); ?>
<!--        --><?//= Html::submitButton('Import file'); ?>
<!--        --><?php //$form->end(); ?>
<!--</div>-->

<div class="invoice-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive' => true,
        'hover' => true,
        'pjax' => false,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ActionColumn', 'template' => '{view}',
                'header' => '<span class="glyphicon glyphicon-info-sign"></span>',
            ],
//            [
//                'attribute' => 'registration_id',
//                'value' => function ($data) {
//                    return $data->registration->email;
//                },
//                'enableSorting' => false
//            ],
            [
                'attribute' => 'registration_id',
                'label' => 'Firstname',
                'filter' => false,
                'value' => function ($data) {
                    return Html::a($data->registration->first_name, Yii::$app->getUrlManager()->createUrl(['/registration/view', 'id' => $data->registration_id]));
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'attribute' => 'registration_id',
                'label' => 'Lastname',
                'filter' => false,
                'value' => function ($data) {
                    return Html::a($data->registration->last_name, Yii::$app->getUrlManager()->createUrl(['/registration/view', 'id' => $data->registration_id]));
                },
                'format' => 'raw',
                'enableSorting' => false
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Invoice date',
                'filter' => false,
                'format' => ['date', 'php:d-m-Y']
            ],
            [
                'attribute' => 'invoice',
                'format' => 'raw',
                'filter' => false,
                'value' => function ($data) {
                    return Html::a($data->invoice, \yii\helpers\Url::to('/statics/pdfs/' . $data->invoice), ['target' => '_blank']);
                },

            ],
            [
                'attribute' => 'deleted',
                'label' => 'Status',
                'value' => function ($data) {
                    return array_key_exists($data->deleted, Invoice::$reverseStatus) ? Invoice::$reverseStatus[$data->deleted] : null;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => Invoice::$nameStatus + ['' => 'All'],
                    //'options' => ['prompt' => Yii::t('general', 'All')],
                ],
            ],
            [
                'attribute' => 'amount',
                'filter' => false,
                'value' => function ($data) {
                    return $data->amount . ' &#8364';
                },
                'format' => 'raw'
            ],
//            'currency',
//            'payment_type',
//            'financial_institution',
//            'order_number',
//            'ref_number',
//            'contract_number',
            [
                'attribute' => 'created_at',
                'filter' => false,
                'format' => ['date', 'php:d.m.Y H:i:s']
            ],
            // 'deleted',

        ],

        //'resizableColumns' => true,
        //'resizeStorageKey' => Yii::$app->user->id . '-' . date('m'),

        //'showPageSummary' => true,

        'toolbar' => [
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => Yii::t('kvgrid', 'Reset Grid')]),
            '{export}',
            '{toggleData}'
        ],
        'toggleDataOptions' => [
            'default' => 'all',
        ],

        'panelBeforeTemplate' => '<div class="pull-right"><div class="btn-toolbar kv-grid-toolbar" role="toolbar"><span class="pager-mini">{pager}</span>{toolbar}</div></div>{before}<div class="clearfix"></div>',
        'panelAfterTemplate' => '{after}<span class="pager-mini">{pager}</span>',

        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-credit-card"></i> Invoice</h3>',
//            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Create Registration', ['create'], ['class' => 'btn btn-success']),
//            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-primary']),
            'footer' => false
        ],


        'exportConfig' => [
            GridView::EXCEL => [],
            GridView::CSV => [
                'config' => [
                    'colDelimiter' => ';',
                    'rowDelimiter' => "\r\n",
                ]],
            GridView::PDF => [],
        ],

    ]); ?>

</div>
