<?php

namespace app\models\logs\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\logs\LogsStatus;

/**
 * LogsStatusSearch represents the model behind the search form about `app\models\logs\LogsStatus`.
 */
class LogsStatusSearch extends LogsStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parcel_id', 'service', 'status', 'product_id', 'user_id', 'updated_by'], 'integer'],
            [['code_start', 'code_end', 'phone', 'device_id', 'lat_lng', 'created_at'], 'safe'],
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
        $query = LogsStatus::find();

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
            'parcel_id' => $this->parcel_id,
            'service' => $this->service,
            'status' => $this->status,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code_start', $this->code_start])
            ->andFilterWhere(['like', 'code_end', $this->code_end])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'lat_lng', $this->lat_lng])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
