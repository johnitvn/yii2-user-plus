<?php

namespace johnitvn\userplus\simple\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form 
 * about `johnitvn\userplus\simple\models\UserAccounts`.
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class UserSearch extends UserAccounts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','creator', 'creator_ip', 'confirmed_at','administrator' ,'created_at', 'updated_at'], 'integer'],
            [['login', 'password'], 'safe'],
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
        $query = UserAccounts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {         
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'creator'=> $this->creator,
            'creator_ip' => $this->creator_ip,
            'confirmed_at' => $this->confirmed_at,
            'administrator'=> $this->administrator,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'login', $this->login]);

        return $dataProvider;
    }
}
