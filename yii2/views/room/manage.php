<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model common\models\Room */

$this->title = 'Create Rooms';
$this->params['breadcrumbs'][] = ['label' => 'Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$this->registerJs(
    '$(document).on("click", "tr td", function(){
         $.ajax({
             type: "POST",
             url: "' . \yii\helpers\Url::to(["/room/allotment"]) . '",
             data: {date: $("#room-datepicker").val(), hotel_id: $("#hotelId").val()},
             success: function(response){
                $("#response").html(response);
             }
         });
     });'
)
?>

<div class="room-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'id' => 'manage-form'
        ]); ?>

        <div class="col-md-3">
            <?= Html::hiddenInput('hotel_id', $_GET['hotel_id'], ['id'=>'hotelId'])?>
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'datePicker',
                'type' => DatePicker::TYPE_INLINE,
                'pluginOptions' => [
                    'format' => 'd-m-yyyy'
                ]
            ]);
            ?>
        </div>

        <div class="col-md-9" id="response">
            <h2>Click on any day to see allotment!</h2>
        </div>

        <?php $form->end() ?>
    </div>

</div>