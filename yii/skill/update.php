<?php
/* @var $this SkillController */
/* @var $model Skill */
/* @var $lastPayRateContractor PayRateContractor */
/* @var $historicalPayRateContractor PayRateContractor[] */

$this->breadcrumbs=array(
        Yii::t('site', 'Admin') => array('site/admin'),
	Yii::t('site', 'Skills')=>array('index'),
	Yii::t('site', 'Update'),
);
?>

<h1><?php echo Yii::t('skill', 'Update Skills').' '.$model->name; ?></h1>
<div class="bg-dark1">
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'lastPayRateContractor' => ($lastPayRateContractor) ?: new PayRateContractor(),
	'historicalPayRateContractor' => $historicalPayRateContractor
)); ?>
</div>