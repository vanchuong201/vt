<?php

namespace app\models\logs\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\logs\LogsCg;

/**
 * LogsCgSearch represents the model behind the search form about `app\models\logs\LogsCg`.
 */
class LogsCgSearch extends LogsCg
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_before', 'status_confirm', 'code_type', 'parcel_id', 'service', 'product_id', 'user_id', 'updated_by'], 'integer'],
            [['code', 'phone', 'device_id', 'lat_lng', 'created_at'], 'safe'],
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
        $query = LogsCg::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status_before' => $this->status_before,
            'status_confirm' => $this->status_confirm,
            'code_type' => $this->code_type,
            'parcel_id' => $this->parcel_id,
            'service' => $this->service,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'lat_lng', $this->lat_lng])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
