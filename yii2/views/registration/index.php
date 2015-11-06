<?php

use yii\helpers\Html;
use common\components\GridView;
use common\models\Registration;
use common\models\Department;
use common\models\Country;
use common\models\Hotel;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Registrations');
$this->registerJsFile('@web/js/grid/main.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="registration-index">
    <?php
    $gridColumns = [
        //['class' => '\kartik\grid\CheckboxColumn'],
        ['class' => '\kartik\grid\SerialColumn'],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{view} {update} {cancel} {delete}',
            'buttons' => [
                'cancel' => function ($key, $model) {
                    $customUrl = Yii::$app->getUrlManager()->createUrl(['registration/cancel-admin', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', $customUrl, [
                        'title' => Yii::t('app', 'Cancel'),
                        'data-pjax' => '0',
                        'confirm' => Yii::t('app', 'Do you really want cancel registration?')
                    ]);
                },
                'delete' => function ($key, $model) {
                    $customUrl = Yii::$app->getUrlManager()->createUrl(['registration/delete-admin', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $customUrl, [
                        'title' => Yii::t('app', 'Delete'),
                        'data-pjax' => '0',
                        'confirm' => Yii::t('app', 'Do you really want delete registration?')
                    ]);
                }
            ],
            'header' => '<span class="glyphicon glyphicon-info-sign"></span>',
            'headerOptions' => [
                'style' => 'min-width:50px;'
            ]
        ],

        [
            'attribute' => 'status',
            'value' => function ($data) {
                return array_key_exists($data->status, Registration::$reverseStatus) ? Registration::$reverseStatus[$data->status] : null;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => Registration::$statusNames + ['' => 'All'],
                //'options' => ['prompt' => Yii::t('general', 'All')],
            ],
            'headerOptions' => [
                'style' => 'min-width:115px;'
            ]
        ],
        'code',
        [
            'attribute' => 'title',
            'value' => function ($data) {
                return Yii::t('general', $data->title);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => Registration::getTitles(),
                'options' => ['prompt' => Yii::t('general', 'All')],
            ],
            'width' => '250px'
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
            'value' => function ($data) {
                return $data->country ? $data->country->name : null;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => Country::getMap(),
                'options' => ['prompt' => Yii::t('general', 'All')],
            ],
            'headerOptions' => [
                'style' => 'min-width:150px;'

            ]
        ],
        'email:email',
        'phone',
        [
            'attribute' => 'department_id',
            'value' => function ($data) {
                return $data->departmentRel ? $data->departmentRel->name : null;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => Department::getMap(),
                'options' => ['prompt' => Yii::t('general', 'All')],
            ],
            'width' => '250px'
        ],
        [
            'attribute' => 'hotel_id',
            'value' => function ($data) {
                return $data->hotel ? $data->hotel->name : null;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => Hotel::getMap(),
                'options' => ['prompt' => Yii::t('general', 'All')],
            ],
            'headerOptions' => [
                'style' => 'min-width:155px;'

            ]
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
                return $data->roomType ? $data->roomType->name : null;
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
                return Registration::generateRoomRate($data->room_rate);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'special_request',
            'hidden' => true
        ],
        [
            'attribute' => 'updated_at',
            'format' => ['date', 'php:h:i:s A d-m-Y'],
        ],
        [
            'attribute' => 'id',
            'hiddenFromExport' => true,
            'headerOptions' => [
                'style' => 'min-width:80px;'
            ]
        ]

    ];

    // Generate a bootstrap responsive striped table with row highlighted on hover
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive' => true,
        //'containerOptions' => ['style' => 'overflow: auto'], //if responcive=false
        'hover' => true,
        'columns' => $gridColumns,

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
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Registrations</h3>',
            'before' => Html::a('<i class="glyphicon glyphicon-list-alt"></i> Hotel Rooming List', ['hotel-rooming'], ['class' => 'btn btn-primary']),
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


        'beforeHeader' => [
            [
                'columns' => [
                    ['options' => ['colspan' => 3]],
                    ['content' => 'Personal Data', 'options' => ['colspan' => 12, 'class' => 'text-center warning']],
                    ['content' => 'Hotel Information', 'options' => ['colspan' => 6, 'class' => 'text-center warning']],
                    //['content'=>'Header Before 3', 'options'=>['colspan'=>3, 'class'=>'text-center warning']],
                ],
                'options' => ['class' => 'skip-export'] // remove this row from export
            ]
        ],
        //'persistResize' => true,
//        'export' => [
//            'fontAwesome' => true
//        ],
    ]); ?>

</div>
