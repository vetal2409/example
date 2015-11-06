<?php
/* @var $this SkillsController */
/* @var $model Skills */

$this->breadcrumbs = array(
        Yii::t('site', 'Admin') => array('site/admin'),
	Yii::t('site', 'Skills'),
);
?>
<h1><?php echo Yii::t('skill', 'Manage Skills'); ?></h1>
<div class="bg-dark1">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'skills-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            'name',
            array(
                'name' => 'pay_rate',
                'value' => '"&pound;" . $data->pay_rate',
                'type' => 'raw',
            ),
            array(
                'class' => 'CButtonColumn',
                'viewButtonOptions' => array('style' => 'display:none'),
            ),
        ),
    ));
    ?>
    <a class="link_button" href="<?php echo $this->createUrl('create'); ?>"><?php echo Yii::t('site', 'Create'); ?></a>
</div>