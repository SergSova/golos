<?php
    namespace app\models\search;

    use app\models\UserIdentity;
    use yii\data\ActiveDataProvider;

    class UserSearch extends UserIdentity{

        public function rules(){
            return [
                [
                    [
                        'id',
                        'candidate',
                        'confirmed'
                    ],
                    'integer'
                ],
                [
                    [
                        'username',
                        'email',
                        'f_name',
                        'l_name'
                    ],
                    'safe'
                ],
            ];
        }

        public function search($queryParams){
            $query = UserIdentity::find();
            $dataProvider = new ActiveDataProvider(['query' => $query]);
            $this->load($queryParams);

            if(!$this->validate()){
                $query->where('0=1');
                return $dataProvider;
            }

            $query->andFilterWhere(['candidate' => $this->candidate])
                  ->andFilterWhere(['id' => $this->id])
                  ->andFilterWhere(['confirmed' => $this->confirmed])
                  ->andFilterWhere([
                                       'like',
                                       'username',
                                       $this->username
                                   ])
                  ->andFilterWhere([
                                       'like',
                                       'email',
                                       $this->email
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