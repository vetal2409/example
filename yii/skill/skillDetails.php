<?php
$model = SkillMapping::getBySkill($id);
$count = 0;
$class_name;
foreach ($model as $contractorSkill)
{
    $time = strtotime(date('Y-m-d')) - strtotime($contractorSkill->expiry_date);
    if(  $time < 7889229 )
    {

        $count++;
        $events = Course::getBySkillAndDate($id, ' >= NOW()');
        $goToCourse = false;
        foreach($events as $event){
            $mapping = CourseMapping::getByCourse($event->id);
            foreach($mapping as $member){
                if($member->contractor_id == $contractorSkill->user_id){
                    $goToCourse = true;
                    break;
                }
            }
        }
        if($time >=0){
            echo '<div><a href="'.Yii::app()->createUrl('course/addToCourse', array('userId'=>$contractorSkill->user_id,
                    'skillId'=>$contractorSkill->skill_id)).'">'.
                    $contractorSkill->user->forename.' '
                    .$contractorSkill->user->surname
                    .Yii::t('skill', ' validate period of ')
                    .$contractorSkill->skill->name
                    .Yii::t('skill', ' has been expired.').
                    CHtml::link('<div class="info_link"></div>', array('user/update', 'id'=>$contractorSkill->user_id));
                    if($goToCourse){
                        echo '<span class="added-skills"></span></div>';
                    }
            echo '</div>';
        }
        elseif($time >= -7889229 ) {
            echo '<div><a href="'
                    .Yii::app()->createUrl(
                            'course/addToCourse',
                            array(
                                'userId'=>$contractorSkill->user_id, 
                                'skillId'=>$contractorSkill->skill_id
                    )).'">'
                    .$contractorSkill->user->forename.' '
                    .$contractorSkill->user->surname
                    .Yii::t('skill', ' validate period of ')
                    .$contractorSkill->skill->name
                    .Yii::t('skill', ' will expire on ')
                    .date('d-m-Y', strtotime($contractorSkill->expiry_date)).
                    CHtml::link('<div class="info_link"></div>', array('user/update', 'id'=>$contractorSkill->user_id));
                    if($goToCourse){
                        echo '<span class="added-skills"></span></div>';
                    }
            echo '</div>';
        }
//        CHtml::link('<div class="info_link"></div>', array('user/update', 'id'=>$contractorSkill->user_id))
    }
}
