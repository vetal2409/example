<?php
/* @var $form2 CActiveForm */
/* @var $this SkillController */
?>
<?php
$form2 = $this->beginWidget('CActiveForm', array(
    'id' => 'add-qualification-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<h1><?php echo Yii::t('skill', 'Add Qualification/License'); ?></h1>
<div class="add-qualification-form bg-dark1">
    <div class="items center_50">
        <?php //echo $form2->errorSummary($model); ?>
        <div class="full-w">
            <b><?php echo CHtml::label(Yii::t('skill', 'Qualification type'), 'skill_id'); ?></b>
            <div class="clearfix">
                <div class="half-w left">
                <?php
                echo $form2->dropDownList($model, 'begin_of_skill_name', $this->getAllBegin(),
                    array(
                        'ajax' => array(
                            'type'=>'POST', //request type
                            'url'=>$this->createUrl('getEndOfName'),
                            //'update'=>'#cusel-scroll-end_of_name',
                            'success'=>'function(r){
                                var first_option = $(r).html();
                                $("#cusel-scroll-SkillMapping_end_of_skill_name").children().remove();
                                $("#cusel-scroll-SkillMapping_end_of_skill_name").append(r);
                                $("#cuselFrame-SkillMapping_end_of_skill_name .cuselText").text(first_option);
                                $("#SkillMapping_end_of_skill_name").attr("value", first_option);
                                $("#cusel-scroll-SkillMapping_end_of_skill_name span[val="+first_option+"]").addClass("cuselActive");
                            }'
                        )
                    )
                );
                echo $form2->error($model, 'begin_of_skill_name');
                ?>
                </div>
                <div class="half-w right">
                    <?php
                        echo CHtml::dropDownList('SkillMapping[end_of_skill_name]', '', $endOfName);
                    ?>
                </div>
            </div>
<?php echo $form2->error($model, 'skill_id'); ?>
        </div>
        <div class="full-w">
                <b><?php echo CHtml::label(Yii::t('skill', 'Expiry date'), 'expiry_date'); ?></b>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'expiry_date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'changeMonth' => true,
                        'dateFormat'=>'d-m-yy',
                        'changeYear' => true,
                        'yearRange' => '-0:+5',
                        'minDate' => '+1d',
                        'showAnim' => 'fold',
                    ),
                    'htmlOptions' => array(
                        'style' => 'height:20px;'
                    ),
                ));
                echo $form2->error($model, 'expiry_date');
                ?>
        </div>
        <div class="full-w">
                <b><?php echo CHtml::label(Yii::t('skill', 'Upload image'), 'image'); ?></b>
                <?php echo $form2->fileField($licenseModel, 'image'); ?>
                <?php echo $form2->error($licenseModel, 'image'); ?>
<?php //echo $form2->hiddenField($qualificationModel, 'user_id', array('value'=>$_GET['id']));  ?>
        </div>
         <div class="full-w">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'link_button')); ?>
         </div>
    </div>
<?php $form2 = $this->endWidget(); ?>
</div>