<?php

    namespace app\controllers;

    use app\models\UserIdentity;
    use app\models\Vote;
    use Yii;
    use yii\filters\VerbFilter;
    use yii\web\Controller;

    class RateController extends Controller{
        public function behaviors(){
            return [
                //                'access' => [
                //                    'class' => AccessControl::className(),
                //                    'only' => [
                //                        'up-vote',
                //                        'down-vote'
                //                    ],
                //                    'rules' => [
                //                        [
                //                            'actions' => [
                //                                'up-vote',
                //                                'down-vote'
                //                            ],
                //                            'allow' => true,
                //                            'roles' => ['?'],
                //                        ],
                //                    ],
                //                ],
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

            $session = Yii::$app->session;
            $user_id = $session->get('user_id');
            $user_time = $session->get('t');

            if(!Yii::$app->user->isGuest){
                $user = Yii::$app->user->identity;
            }
            if($candidate->candidate && !Vote::find()
                                             ->where([
                                                         'candidate_id' => $candidate->id,
                                                         'user_session' => $user_id
                                                     ])
                                             ->exists()
            ){
                $date = [
                    'time_diff' =>  time() - $user_time,
                    'HTTP_USER_AGENT'=>$_SERVER['HTTP_USER_AGENT'],
                    'REMOTE_ADDR'=>$_SERVER['REMOTE_ADDR']
                ];
                $vote = new Vote([
                                     'candidate_id' => $candidate->id,
                                     'user_id' => $user->id,
                                     'user_session' => $user_id,
                                     'user_info' => json_encode($date),
                                     'vote' => 1
                                 ]);
                if($vote->save()){
                    return json_encode($candidate->allVote);
                }
            }

            return '{"error":"Вы уже голосовали"}';
        }

        public function actionDownVote(){
            $candidate = UserIdentity::findOne(Yii::$app->request->post('id'));

            $session = Yii::$app->session;
            $user_id = $session->get('user_id');
            $user_time = $session->get('t');

            if(!Yii::$app->user->isGuest){
                $user = Yii::$app->user->identity;
            }
            if($candidate->candidate && !Vote::find()
                                             ->where([
                                                         'candidate_id' => $candidate->id,
                                                         'user_session' => $user_id
                                                     ])
                                             ->exists()
            ){
                $date = [
                    'time_diff' =>  time() - $user_time,
                    'HTTP_USER_AGENT'=>$_SERVER['HTTP_USER_AGENT'],
                    'REMOTE_ADDR'=>$_SERVER['REMOTE_ADDR']
                ];
                $vote = new Vote([
                                     'candidate_id' => $candidate->id,
                                     'user_id' => $user->id,
                                     'user_session' => $user_id,
                                     'user_info' => json_encode($date),
                                     'vote' => -1
                                 ]);
                if($vote->save()){
                    return json_encode($candidate->allVote);
                }
            }

            return '{"error":"Вы уже голосовали"}';
        }
    }