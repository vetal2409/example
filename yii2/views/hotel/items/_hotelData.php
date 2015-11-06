<?php
use vova07\imperavi\Widget;

?>

<div class="col-md-12">
    <div class="row">

        <?= $form->field($modelHotelData, 'lang_id[]')->hiddenInput(['value' => $language->local])->label(false) ?>
        <div class="control-label">Description</div>
        <?= Widget::widget([
            'name' => 'HotelData[description][]',
            'value' => $modelHotelData->description,
            'settings' => [
                'minHeight' => 200,
                'plugins' => [
                    'clips',
                ]
            ]
        ]);
        ?>
        <div class="control-label">Location</div>
        <?= Widget::widget([
            'name' => 'HotelData[location][]',
            'value' => $modelHotelData->location,
            'settings' => [
                'minHeight' => 200,
                'plugins' => [
                    'clips',
                ]
            ]
        ]);
        ?>
        <div class="control-label">Price information</div>
        <?= Widget::widget([
            'name' => 'HotelData[price_information][]',
            'value' => $modelHotelData->price_information,
            'settings' => [
                'minHeight' => 200,
                'plugins' => [
                    'clips',
                ]
            ]
        ]);
        ?>
        <div class="control-label">Other</div>
        <?= Widget::widget([
            'name' => 'HotelData[other][]',
            'value' => $modelHotelData->other,
            'settings' => [
                'minHeight' => 200,
                'plugins' => [
                    'clips',
                ]
            ]
        ]);
        ?>
    </div>
</div>