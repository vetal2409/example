<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Country;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create City', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'country_id',
                'value' => function ($data) {
                    return $data->country ? $data->country->name : null;
                },
                'filter' => Country::getMap()
            ],
//            [
//                'attribute' => 'created_at',
//                'format' => ['date', 'php:h:i:s A d-m-Y']
//            ],
//            [
//                'attribute' => 'created_by',
//                'value' => function($data) {
//                    return $data->creator ? $data->creator->username : null;
//                }
//            ],
//            [
//                'attribute' => 'updated_at',
//                'format' => ['date', 'php:h:i:s A d-m-Y']
//            ],
//            [
//                'attribute' => 'created_by',
//                'value' => function($data) {
//                    return $data->updatedBy ? $data->updatedBy->username : null;
//                }
//            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    Pjax::end(); ?>

</div>
