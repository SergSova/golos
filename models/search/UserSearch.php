<?php
    namespace app\models\search;

    use app\models\User;
    use yii\data\ActiveDataProvider;

    class UserSearch extends User{


        public function search($queryParams){
            $query = User::find();
            $dataProvider = new ActiveDataProvider(['query' => $query]);
            $this->load($queryParams);

            if(!$this->validate()){
                return $dataProvider;
            }

            $query->andFilterWhere(['candidate' => $this->candidate])
                  ->andFilterWhere([
                                       'like',
                                       'username',
                                       $this->username
                                   ])
                  ->andFilterWhere([
                                       'like',
                                       'f_name',
                                       $this->f_name
                                   ])
                  ->andFilterWhere([
                                       'like',
                                       'l_name',
                                       $this->l_name
                                   ]);

            return $dataProvider;
        }
    }