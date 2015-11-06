<?php

namespace common\components;

use Yii;

class ActiveQuery extends \yii\db\ActiveQuery
{

    /**
     * @return $this
     */
    public function deleted()
    {
        $this->byDelete(ActiveRecord::STATUS_DELETED);
        return $this;
    }

    /**
     * @return $this
     */
    public function notDeleted()
    {
        $this->byDelete(ActiveRecord::STATUS_NOT_DELETED);
        return $this;
    }

    /**
     * @param integer $status
     * @return $this
     */
    public function byDelete($status)
    {
        $this->andWhere(['deleted' => $status]);
        return $this;
    }

    /**
     * @return static
     */
    public function my() {
        return $this->andWhere(['created_by' => Yii::$app->user->id]);
    }

}