<?php

namespace backend\models;

use common\models\HotelData;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Hotel;

/**
 * HotelSearch represents the model behind the search form about `common\models\Hotel`.
 */
class HotelSearch extends Hotel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stars', 'country_id', 'city_id', 'zip', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted', 'preview_image_id'], 'integer'],
            [['name', 'phone', 'fax', 'address'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Hotel::find()->notDeleted()->with('hotelData'); //->allowed()

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'stars' => $this->stars,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'zip' => $this->zip,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
