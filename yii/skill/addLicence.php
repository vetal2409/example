<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#LicenseMapping_image").change(function(){
                $(".file-wrap .file-text").text($(this).val());
            })
        });
    </script>
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <?php echo $form->labelEx($model,'image'); ?>
    <div class="file-wrap">
        <a href="#" class="browse">Browse</a>
        <span class="file-text"></span>
        <?php echo $form->fileField($model,'image', array('accept'=>'image/jpeg,image/png,image/gif,image/jpg,application/pdf')); ?>
    </div>
    <?php echo $form->error($model,'image'); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('site', 'Create') : Yii::t('site', 'Save'), array('class' => 'link_button')); ?>
</div>
<?php $this->endWidget(); ?>