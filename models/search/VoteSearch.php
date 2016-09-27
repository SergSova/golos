<?php

    namespace app\models\search;

    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use app\models\Vote;
    use yii\db\ActiveQuery;

    /**
     * VoteSearch represents the model behind the search form about `app\models\Vote`.
     */
    class VoteSearch extends Vote{
//        public $user;
        public $candidate;

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'user_info'
                    ],
                    'safe'
                ],
                [
                    [
//                        'user',
                        'candidate'
                    ],
                    'string'
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function scenarios(){
            $scenarios = Model::scenarios();
            $scenarios[] = 'user';
            $scenarios[] = 'candidate';

            return $scenarios;
        }

        /**
         * Creates data provider instance with search query applied
         *
         * @param array $params
         *
         * @return ActiveDataProvider
         */
        public function search($params){
            $query = Vote::find();

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                                                       'query' => $query,
                                                       'sort' => [
                                                           'attributes' => [
//                                                               'user' => [
//                                                                   'asc' => ['u.f_name' => SORT_ASC],
//                                                                   'desc' => ['u.f_name' => SORT_DESC],
//                                                               ],
                                                               'candidate' => [
                                                                   'asc' => ['c.f_name' => SORT_ASC],
                                                                   'desc' => ['c.f_name' => SORT_DESC],
                                                               ],
                                                               'vote'
                                                           ]
                                                       ]
                                                   ]);

            $this->load($params);

            if(!$this->validate()){
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                                       'user_id' => $this->user_id,
                                       'vote' => $this->vote,
                                       'candidate_id' => $this->candidate_id,
                                   ]);
//            $query->joinWith([
//                                 'user u' => function($q){
//                                     /** @var ActiveQuery $q */
//                                     $q->where('u.f_name LIKE "%'.$this->user.'%"')
//                                       ->andWhere('u.l_name LIKE "%'.$this->user.'%"');
//                                 }
//                             ]);
            $query->joinWith([
                                 'candidate c' => function($q){
                                     /** @var ActiveQuery $q */
                                     $q->where('c.f_name LIKE "%'.$this->candidate.'%"')
                                       ->andWhere('c.l_name LIKE "%'.$this->candidate.'%"');
                                 }
                             ]);
            $query->andFilterWhere([
                                       'like',
                                       'user_session',
                                       $this->user_session
                                   ])
                  ->andFilterWhere([
                                       'like',
                                       'user_info',
                                       $this->user_info
                                   ]);

            return $dataProvider;
        }
    }
