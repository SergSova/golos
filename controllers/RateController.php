<?php

    namespace app\controllers;

    use app\models\UserIdentity;
    use app\models\Vote;
    use Yii;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\web\Controller;

    class RateController extends Controller{
        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => [
                        'up-vote',
                        'down-vote'
                    ],
                    'rules' => [
                        [
                            'actions' => ['up-vote','down-vote'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'up-vote' => ['post'],
                        'down-vote' => ['post'],
                    ],
                ],
            ];
        }

        public function actionUpVote(){
            $candidate = UserIdentity::findOne(Yii::$app->request->post('id'));
            $user = Yii::$app->user->identity;
            if($candidate->candidate && !Vote::find()
                                             ->where([
                                                         'candidate_id' => $candidate->id,
                                                         'user_id' => $user->id
                                                     ])
                                             ->exists()
            ){
                $vote = new Vote([
                                     'candidate_id' => $candidate->id,
                                     'user_id' => $user->id,
                                     'vote' => true
                                 ]);
                if($vote->save()){
                    return json_encode($candidate->allVote);
                }
            }

            return '{"error":"Вы уже голосовали"}';
        }
        public function actionDownVote(){
            $candidate = UserIdentity::findOne(Yii::$app->request->post('id'));
            $user = Yii::$app->user->identity;
            if($candidate->candidate && !Vote::find()
                                             ->where([
                                                         'candidate_id' => $candidate->id,
                                                         'user_id' => $user->id
                                                     ])
                                             ->exists()
            ){
                $vote = new Vote([
                                     'candidate_id' => $candidate->id,
                                     'user_id' => $user->id,
                                     'vote' => false
                                 ]);
                if($vote->save()){
                    return json_encode($candidate->allVote);
                }
            }

            return '{"error":"Вы уже голосовали"}';
        }
    }