<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RoomType */

$this->title = 'Create Room Type';
$this->params['breadcrumbs'][] = ['label' => 'Room Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
