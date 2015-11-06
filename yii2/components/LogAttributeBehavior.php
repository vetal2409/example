<?php

namespace common\components;

use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;


/**
 * Class LogAttributeBehavior
 */
class LogAttributeBehavior extends Behavior
{
    /**
     * @var ActiveRecord $owner
     */
    public $owner;
    public $createdAtAttribute = 'created_at';
    public $createdByAttribute = 'created_by';

    public $updatedAtAttribute = 'updated_at';
    public $updatedByAttribute = 'updated_by';

    public $deletedAttribute = 'deleted';


    /**
     * @inheritdoc
     */

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete'
        ];
    }


    public function beforeInsert()
    {
        $this->setAttribute($this->createdAtAttribute, time());
        $this->setAttribute($this->createdByAttribute, Yii::$app->user->id ?: 0);
    }

    public function beforeUpdate()
    {
        $this->setAttribute($this->updatedAtAttribute, time());
        $this->setAttribute($this->updatedByAttribute, Yii::$app->user->id ?: 0);
    }

    /**
     * @param \yii\base\ModelEvent $event
     */
    public function beforeDelete($event)
    {
        $this->beforeUpdate();
        $this->setAttribute($this->deletedAttribute, ActiveRecord::STATUS_DELETED);
        $this->owner->save();
        $event->isValid = false;
    }

    public function setAttribute($name, $value)
    {
        if ($this->owner->hasAttribute($name)) {
            $this->owner->setAttribute($name, $value);
        }
    }

}