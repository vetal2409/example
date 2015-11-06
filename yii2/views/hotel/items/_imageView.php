<?php
use common\models\Image;
use \yii\helpers\Html;
/**
 * @var $model common\models\Image
 */
?>
<div class="col-md-3 image-holder">
    <?= Html::hiddenInput('hotel_id', $model->hotel_id, ['id' => 'hotel-id'])?>
    <?= Html::hiddenInput('image_id', $model->id, ['id' => 'image-id'])?>

    <?= Image::showImage($model->id, $model->name) ?>
    <?= Html::button('Make preview image', ['class' => 'text left btn btn-primary', 'id' => 'make-preview'])?>
    <?= Html::button('Delete', ['class' => 'text right btn btn-primary', 'id' => 'delete-image'])?>
</div>