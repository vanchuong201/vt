<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Stamps;

/**
 * StampsSearch represents the model behind the search form about `app\models\Stamps`.
 */
class StampsSearch extends Stamps
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'parcel_id', 'status', 'active_time', 'own_product', 'expire_time', 'created_time', 'stamp_service', 'counter', 'current_counter'], 'integer'],
            [['code_id', 'serial', 'qrm', 'code_sms', 'otp', 'device_id', 'phone', 'geo_location', 'city', 'district', 'address', 'ip', 'to_city', 'to_district', 'to_address', 'sim_manage'], 'safe'],
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
        $query = Stamps::find();

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
            'product_id' => $this->product_id,
            'parcel_id' => $this->parcel_id,
            'status' => $this->status,
            'active_time' => $this->active_time,
            'own_product' => $this->own_product,
            'expire_time' => $this->expire_time,
            'created_time' => $this->created_time,
            'stamp_service' => $this->stamp_service,
            'counter' => $this->counter,
            'current_counter' => $this->current_counter,
        ]);

        $query->andFilterWhere(['like', 'code_id', $this->code_id])
            ->andFilterWhere(['like', 'serial', $this->serial])
            ->andFilterWhere(['like', 'qrm', $this->qrm])
            ->andFilterWhere(['like', 'code_sms', $this->code_sms])
            ->andFilterWhere(['like', 'otp', $this->otp])
            ->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'geo_location', $this->geo_location])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'to_city', $this->to_city])
            ->andFilterWhere(['like', 'to_district', $this->to_district])
            ->andFilterWhere(['like', 'to_address', $this->to_address])
            ->andFilterWhere(['like', 'sim_manage', $this->sim_manage]);

        return $dataProvider;
    }

    public function searchCg($params)
    {
        $query = Stamps::find()->where(['stamp_service'=>Yii::$app->params['service_has_chong_gia']]);

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
            'product_id' => $this->product_id,
            'parcel_id' => $this->parcel_id,
            'status' => $this->status,
            'active_time' => $this->active_time,
            'own_product' => $this->own_product,
            'expire_time' => $this->expire_time,
            'created_time' => $this->created_time,
            'stamp_service' => $this->stamp_service,
            'counter' => $this->counter,
            'current_counter' => $this->current_counter,
        ]);

        $query->andFilterWhere(['like', 'code_id', $this->code_id])
            ->andFilterWhere(['like', 'serial', $this->serial])
            ->andFilterWhere(['like', 'qrm', $this->qrm])
            ->andFilterWhere(['like', 'code_sms', $this->code_sms])
            ->andFilterWhere(['like', 'otp', $this->otp])
            ->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'geo_location', $this->geo_location])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'to_city', $this->to_city])
            ->andFilterWhere(['like', 'to_district', $this->to_district])
            ->andFilterWhere(['like', 'to_address', $this->to_address])
            ->andFilterWhere(['like', 'sim_manage', $this->sim_manage]);

        return $dataProvider;
    }
}
