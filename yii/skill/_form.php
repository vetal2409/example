<?php
/* @var $this SkillController */
/* @var $model Skill */
/* @var $lastPayRateContractor PayRateContractor */
/* @var $historicalPayRateContractor PayRateContractor[] */
/* @var $form CActiveForm */
?>

<?php if ($historicalPayRateContractor && count($historicalPayRateContractor) > 0) : ?>
    <table class="admin-skill-table">
        <tr>
            <th>
                Date Begin
            </th>
            <th>
                Date End
            </th>
            <td>
                Pay Rate &pound;
            </td>
        </tr>
        <?php foreach ($historicalPayRateContractor as $single) : ?>
            <tr>
                <td>
                    <?php echo date('Y-m-d', $single->date_begin)?>
                </td>
                <td>
                    <?php echo date('Y-m-d', $single->date_end)?>
                </td>
                <td>
                    <?php echo $single->pay_rate?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<div class="form center_50">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'skill-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <p class="note"><?php echo Yii::t('site', 'Fields with'); ?> <span
            class="required">*</span><?php echo Yii::t('site', ' are required.'); ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="row full-w">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
    <div class="row full-w">
        <?php echo $form->labelEx($model, 'pay_rate'); ?>
        <?php echo $form->textField($model, 'pay_rate', array('size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'pay_rate'); ?>
    </div>
    <div class="row full-w">
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'pay_rate_contractor_begin',
            'options' => array(
                'shoAnim' => 'fold',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'value' => ($lastPayRateContractor->date_begin > 0) ? date('Y-m-d', $lastPayRateContractor->date_begin) : date('Y-m-d', time())
            )
        )) ?>
    </div>
    <div class="row full-w">
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'pay_rate_contractor_end',
            'options' => array(
                'shoAnim' => 'fold',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'value' => ($lastPayRateContractor->date_end > 0) ? date('Y-m-d', $lastPayRateContractor->date_end) : date('Y-m-d', time())
            )
        )) ?>
    </div>
    <div class="row full-w">
        <?php echo $form->labelEx($model, 'hide'); ?>
        <?php echo $form->checkBox($model, 'hide') ?>
        <?php echo CHtml::label('', 'Skill_hide') ?>
        <?php echo $form->error($model, 'hide'); ?>
    </div>
    <div class="button-column">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('site', 'Create') : Yii::t('site', 'Save'), array('class' => 'link_button')); ?>
        <a class="link_button" href="<?php echo $this->createUrl('index'); ?>"><?php echo Yii::t('site', 'Back'); ?></a>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->