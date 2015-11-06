<?php
/* @var $this SkillsController */
/* @var $model Skills */

$this->breadcrumbs=array(
	Yii::t('site', 'Admin') => array('site/admin'),
	Yii::t('site', 'Skills')=>array('index'),
	$model->name,
);
?>
<h1><?php echo Yii::t('skill', 'View Skills').' #'.$model->id; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
