<?php

use yii\helpers\Html;
use common\components\GridView;
use common\models\Registration;
use common\models\Hotel;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Registrations');
?>
<div class="registration-index">
    <?php
    $gridColumns = [
        //['class' => '\kartik\grid\SerialColumn'],

        [
            'attribute' => 'status',
            'value' => function ($data) {
                return isset($data->status) && array_key_exists($data->status, Registration::$reverseStatus) ? Registration::$reverseStatus[$data->status] : null;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => Registration::$statusNames + ['' => 'All'],
            ],
            'headerOptions' => [
                'style' => 'min-width:115px;'
            ]
        ],
        'first_name',
        'last_name',
        'company',
        'department',
        [
            'attribute' => 'hotel_id',
            'value' => function ($data) {
                return isset($data->hotel) && $data->hotel ? $data->hotel->name : null;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => Hotel::getMap(),
                'options' => ['prompt' => Yii::t('general', 'All')],
            ],
            'headerOptions' => [
                'style' => 'min-width:155px;'

            ],
        ],
        [
            'attribute' => 'check_in',
            'format' => ['date', 'php:d/m/Y'],
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => Registration::getCheckIn(),
                'options' => ['prompt' => Yii::t('general', 'All')],
            ],
            'headerOptions' => [
                'style' => 'min-width:115px;'

            ]
        ],
        [
            'attribute' => 'check_out',
            'format' => ['date', 'php:d/m/Y'],
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => Registration::getCheckOut(),
                'options' => ['prompt' => Yii::t('general', 'All')],
            ],
            'headerOptions' => [
                'style' => 'min-width:115px;'

            ]
        ],
        [
            'attribute' => 'room_type_id',
            'value' => function ($data) {
                return isset($data->roomType) && $data->roomType ? $data->roomType->name : null;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => \common\models\RoomType::getMap(),
                'options' => ['prompt' => Yii::t('general', 'All')],
            ],
        ],
        [
            'attribute' => 'room_rate',
            'value' => function ($data) {
                return isset($data->room_rate) ? Registration::generateRoomRate($data->room_rate) : null;
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'updated_at',
            'format' => ['date', 'php:h:i:s A d-m-Y'],
        ],
        'd12',
//        [
//            'attribute' => 'd12',
//            'options' => [
//                //'style' => 'background-color: #FBE4D5!important; : hover',
//                'class' => 'test'
//            ]
//        ],
        'd13',
        'd14',
        'd15',
        'd16'
    ];

    // Generate a bootstrap responsive striped table with row highlighted on hover
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'responsive' => true,
        //'containerOptions' => ['style' => 'overflow: auto'], //if responcive=false
        'hover' => true,
        'columns' => $gridColumns,
//        'rowOptions' => function ($model, $key, $index, $grid) {
//            $qq = 1;
//        },
//        'rowOptions' => [
//            'style' => 'color:red;'
//        ],

        'pjax' => true,

        'resizableColumns' => false,
//        'resizeStorageKey' => Yii::$app->user->id . '-' . date('m'),

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
        'panelAfterTemplate' => '{after}<span class="pager-mini clearfix">{pager}</span>',

        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Hotel Rooming List</h3>',
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Create Registration', ['create'], ['class' => 'btn btn-success']),
            //'after' => '',
            'footer' => false,
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
