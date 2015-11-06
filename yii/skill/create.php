<?php
/* @var $this SkillController */
/* @var $model Skill */
/* @var $lastPayRateContractor PayRateContractor */

$this->breadcrumbs=array(
	Yii::t('site', 'Admin') => array('site/admin'),
	Yii::t('site', 'Skills')=>array('index'),
	Yii::t('site', 'Create'),
);
?>
<h1><?php echo Yii::t('skill', 'Create Skills'); ?></h1>
<div class="bg-dark1">
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'lastPayRateContractor' => $lastPayRateContractor
)); ?>
</div>