<?php
if($withLink)
{
    if (!Yii::app()->request->isAjaxRequest || $_GET['return_js'])
        echo CHtml::ajaxLink('<div class="'.$skill->status.'"></div>',
            Yii::app()->createUrl('skill/toggleStatus',array('id'=>$skill->id)),
            array('success'=>'function(r){$(".status-'.$skill->id.'").load("'.Yii::app()->createUrl('skill/status', array('id'=>$skill->id, 'withLink'=>true)).'");}'),
            array('id'=>'h'.$skill->id)
        );
    else echo '<a href="#" id="h'.$skill->id.'"><div class="'.$skill->status.'"></div></a>';
}
else echo '<div class="'.$skill->status.'"></div>';
?>