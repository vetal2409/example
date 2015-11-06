<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'add-qualification-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<?php echo Yii::t('skill', 'Edit Qualification/License'); ?>
<table>
    <tr>
        <th><?php echo Yii::t('skill', 'Qualification type'); ?></th>
        <td>
            <?php echo $form->dropDownList($model, 'skill_id', $this->getAll()); ?>
            <?php echo $form->error($model, 'skill_id'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo Yii::t('skill', 'Expiry date'); ?></th>
        <td>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'expiryDate',
                'model' => $model,
                'attribute' => 'expiry_date',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            ?>
        </td>
    </tr>
    <tr>
        <th><?php echo Yii::t('skill', 'Upload image:'); ?></th>
        <td>
            <?php echo $form->fileField($model, 'image'); ?>
            <?php echo $form->error($model, 'image'); ?>
            <?php echo $form->hiddenField($model, 'user_id', array('value' => $model->user_id)); ?>
            <div class="row buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('site', 'Create') : Yii::t('site', 'Save'), array('class' => 'link_button')); ?>
            </div>
        </td>
    </tr>
    <br>
</table>
<?php $form2 = $this->endWidget(); ?>