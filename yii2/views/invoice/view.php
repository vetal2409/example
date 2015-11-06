<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Invoice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'buttons1' => '',
        'panel' => [
            'heading' => 'Invoice',
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            [
                'attribute' => 'registration_id',
                'value' => $model->registration->email,
            ],
            [
                'attribute' => 'invoice',
                'format' => 'raw',
                'value' => Html::a($model->invoice, \yii\helpers\Url::to('/statics/pdfs/' . $model->invoice), ['target' => '_blank'])
            ],
            'currency',
            'payment_type',
            'financial_institution',
            'order_number',
            'ref_number',
            'contract_number',
            [
                'attribute' => 'amount',
                'format' => 'raw',
                'value' => $model->amount . ' &#8364'
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y']
            ],
        ]
    ]); ?>

</div>
