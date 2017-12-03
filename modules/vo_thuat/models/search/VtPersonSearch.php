<?php

namespace app\modules\vo_thuat\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\vo_thuat\models\VtPerson;

/**
 * VtPersonSearch represents the model behind the search form about `app\modules\vo_thuat\models\VtPerson`.
 */
class VtPersonSearch extends VtPerson
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'don_vi', 'chuc_vu', 'mon_vo', 'dang', 'dang_cap', 'dai', 'cap'], 'integer'],
            [['id_card', 'full_name', 'birthday', 'cmnd', 'phone', 'email', 'address', 'description'], 'safe'],
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
        $query = VtPerson::find();

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
            'don_vi' => $this->don_vi,
            'chuc_vu' => $this->chuc_vu,
            'mon_vo' => $this->mon_vo,
            'dang' => $this->dang,
            'dang_cap' => $this->dang_cap,
            'dai' => $this->dai,
            'cap' => $this->cap,
        ]);

        $query->andFilterWhere(['like', 'id_card', $this->id_card])
            ->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'cmnd', $this->cmnd])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
