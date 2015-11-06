<?php

namespace common\components;

use Yii;
use common\models\User;

/**
 * Class ActiveRecord
 * @package common\components
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $deleted
 * @method ActiveQuery hasMany(string $class, array $link) see BaseActiveRecord::hasMany() for more info
 * @method ActiveQuery hasOne(string $class, array $link) see BaseActiveRecord::hasOne() for more info
 * @property User $createdBy
 * @property User $updatedBy
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 1;
    const STATUS_NOT_DELETED = 0;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            LogAttributeBehavior::className()
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by'])->notDeleted();
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by'])->notDeleted();
    }

    /**
     * @return bool
     */
    public function ifMy () {
        return $this->created_by && $this->created_by === Yii::$app->user->id ?: false;
    }
}