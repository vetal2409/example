<?php


namespace backend\models;

use common\models\UserHotelMapping;
use Yii;
use common\components\ActiveQuery;

/**
 * Class HotelQuery
 * @package backend\models
 */
class HotelQuery extends ActiveQuery
{

    public function allowed()
    {
        if (Yii::$app->user->isRoot) {
            return $this;
        }
        $ids = [];
        $models = (array)UserHotelMapping::find()->notDeleted()->select('hotel_id')->where(['user_id' => Yii::$app->user->id])->all();
        if (count($models)) {
            foreach ($models as $model) {
                $ids[] = $model->hotel_id;
            }
        }
        return $this->andWhere(['id' => $ids]);
    }
}