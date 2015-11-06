<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
//use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use \yii\widgets\ListView;
use vova07\imperavi\Widget;
use kartik\tabs\TabsX;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Hotel */
/* @var $availableRooms array() */
/* @var $imageDataProvider common\models\Image */
/* @var $modelHotelRoomTypeMapping common\models\HotelRoomTypeMapping */
/* @var $roomTypes [] common\models\RoomType */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelHotelData common\models\HotelData */
?>

<?php
$this->registerJs(
    '$(document).on("click", "#make-preview", function(){
         $.ajax({
             type: "POST",
             url: "' . Url::to(["/hotel/set-preview-image"]) . '",
             data: {hotel_id: $("#hotel-id").val(), image_id: $("#image-id").val()},
             success: function(response){
                alert("Preview image changed");
             }
         });
     });
     $(document).on("click", "#delete-image", function(){
         $.ajax({
             type: "POST",
             url: "' . Url::to(["/hotel/delete-image"]) . '",
             data: {image_id: $("#image-id").val()},
             success: function(response){
                $.pjax.reload({container: "#image-list"});k
             }
         });
     });
     '
)
?>

<div class="hotel-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'file[]')->widget(FileInput::className(), [
        'options' => ['multiple' => true, 'accept' => 'image/*'],
        'pluginOptions' => [
            'previewFileType' => 'image',
            'showRemove' => true
        ]
    ]) ?>

    <?php \yii\widgets\Pjax::begin(); ?>

    <?php if (!$model->isNewRecord) : ?>
        <div class="col-md-12">
            <?= ListView::widget([
                'id' => 'image-list',
                'dataProvider' => $imageDataProvider,
                'itemView' => 'items/_imageView',
                'layout' => '{items}'
            ]) ?>
        </div>
    <?php endif ?>

    <?php \yii\widgets\Pjax::end(); ?>


    <!--    --><? //= $form->field($model, 'phone')->textInput(['maxlength' => 25]) ?>
    <!---->
    <!--    --><? //= $form->field($model, 'fax')->textInput(['maxlength' => 25]) ?>
    <!---->
    <!--    --><? //= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map($countries, 'id', 'name')) ?>
    <!---->
    <!--    --><? //= $form->field($model, 'cityName')->textInput(['value' => ($model->isNewRecord) ? '' : $model->city->name]) ?>

    <!--    --><? //= $form->field($model, 'zip')->textInput() ?>
    <!---->
    <!--    --><? //= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?
    foreach ($languages as $key => $language) {
        $modelHotelData = \common\models\HotelData::getByLanguageIdAndHotelId($language->local, $model->id);
        $items[] = [
            'label' => $language->name,
            'content' => $this->render('items/_hotelData', [
                'modelHotelData' => ($modelHotelData) ?: new \common\models\HotelData(),
                'language' => $language,
                'uniqid' => uniqid(),
                'form' => $form
            ])
        ];
    }
    ?>
    <?= TabsX::widget([
        'items' => $items,
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false
    ])?>



    <?php ($model->isNewRecord) ? false : $modelHotelRoomTypeMapping->room_type_id = $availableRooms ?>
    <?= $form->field($modelHotelRoomTypeMapping, 'room_type_id')->checkboxList(ArrayHelper::map($roomTypes, 'id', 'name'),
        ['separator' => '<br>']) ?>

    <?php ($model->isNewRecord) ? false : $modelHotelDepartmentMapping->department_id = $hotelDepartments ?>
    <?= $form->field($modelHotelDepartmentMapping, 'department_id')->checkboxList(ArrayHelper::map($department, 'id', 'name'),
        ['separator' => '<br>']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
