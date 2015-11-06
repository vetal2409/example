<?php

use yii\helpers\Html;
use common\components\GridView;
use common\models\Hotel;
use common\models\RoomType;
use common\models\Registration;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RoomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rooms');
?>
<div class="room-index">
    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        [
            'attribute' => 'hotel_id',
            'value' => function($data){
                return $data->hotel->name;
            },
            'filter' => Hotel::getMap()
        ],
        [
            'attribute' => 'room_type_id',
            'value' => function($data){
                return $data->roomType->name;
            },
            'filter' => RoomType::getMap()
        ],
        [
            'attribute' => 'date',
            'format' => ['date', 'php:d-m-Y'],
            'filterType' => GridView::FILTER_DATE,
            'filterWidgetOptions' => [
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd-mm-yyyy'
                ]
            ],
            'width' => '180px'
        ],
        'allotment',

        [
            'attribute' => 'booked',
            'value' => function($data) {
                $data->booked = $data->getBooked();
                return $data->booked;
            }
        ],
        [
            'attribute' => 'free',
            'value' => function($data) {
                return $data->allotment - $data->booked;
            }
        ],
        [
            'attribute' => 'price',
            'value' => function ($data) {
                return Registration::generateRoomRate($data->price);
            },
            'format' => 'raw'
        ]


//            ['class' => 'yii\grid\ActionColumn'],
    ];

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'responsive' => true,
        //'containerOptions' => ['style' => 'overflow: auto'], //if responcive=false
        'hover' => true,
        'pjax' => true,
        'resizableColumns' => false,
//        'resizeStorageKey' => Yii::$app->user->id . '-' . date('m'),
//        'showPageSummary' => true,

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
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i>' . Html::encode($this->title). '</h3>',
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
