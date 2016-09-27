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
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'up-vote' => ['post'],
                        'down-vote' => ['post'],
                    ],
                ],
            ];
        }

        public function actionVote(){
            $candidate = UserIdentity::findOne(Yii::$app->request->post('id'));
            $value = Yii::$app->request->post('value');

            $session = Yii::$app->session;
            $cookies = Yii::$app->request->cookies;

            $user_cookie = $cookies->get('user_cookie')->value;
            $user_session = $session->get('user_session');
            $user_time = $session->get('t');

            if(!Yii::$app->user->isGuest){
                $user = Yii::$app->user->identity;
            }
            if(!Vote::find()
                    ->where([
                                'candidate_id' => $candidate->id,
                                'user_cookie' => $user_cookie,
                            ])
                    ->exists()
            ){
                $date = [
                    'time_diff' => microtime() - $user_time,
                    'userAgent' => Yii::$app->request->userAgent,
                    'user_ip' => Yii::$app->request->userIP
                ];
                $vote = new Vote([
                                     'candidate_id' => $candidate->id,
                                     'user_id' => $user->id,
                                     'user_session' => $user_session,
                                     'user_cookie' => $user_cookie,
                                     'user_info' => json_encode($date),
                                     'vote' => $value
                                 ]);
                if($vote->save()){
                    return json_encode($candidate->allVote);
                }
            }
            //Yii::$app->session->setFlash('error', 'Что то пошло не так');
            return '{"error":"Вы уже голосовали"}';
        }
    }