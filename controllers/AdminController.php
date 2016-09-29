<?php

    namespace app\controllers;

    use app\models\search\UserSearch;
    use app\models\search\VoteSearch;
    use app\models\UserIdentity;
    use app\models\Vote;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;

    class AdminController extends Controller{
        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'matchCallback' => function(){
                                return Yii::$app->user->identity->role == 'admin';
                            }
                        ],
                    ],
                ],
            ];
        }

        public function actionCandidates(){
            $searchUser = new UserSearch(['candidate' => true]);
            $dataProvider = $searchUser->search(Yii::$app->request->queryParams);

            return $this->render('candidate', ['dataProvider' => $dataProvider]);
        }

        public function actionUsers(){
            $searchUser = new UserSearch();
            $dataProvider = $searchUser->search(Yii::$app->request->queryParams);

            return $this->render('users', ['dataProvider' => $dataProvider]);
        }

        public function actionUserVotes($id){
            $user = UserIdentity::findOne($id);

            return $this->render('user_votes', ['votes' => $user->votes0]);
        }

        public function actionVotes(){
            $searchVote = new VoteSearch();
            $dataProvider = $searchVote->search(Yii::$app->request->queryParams);

            return $this->render('votes', [
                'dataProvider' => $dataProvider,
                'searchVote' => $searchVote
            ]);
        }

        public function actionRemoveCandidate($id){
            $model = UserIdentity::findOne($id);
            $model->candidate = 0;
            $model->scenario = 'candidate';
            $model->save();

            return $this->redirect(['candidates']);
        }

        public function actionCandidateVotes($id){
            $candidate = UserIdentity::findOne($id);

            return $this->render('candidate_votes', ['candidate' => $candidate]);
        }

        public function actionVoteBySession($session){
            $models = Vote::findAll(['user_session' => $session]);

            return $this->render('votes_by', ['models' => $models]);
        }

        public function actionVoteByCookie($cookie){
            $models = Vote::findAll(['user_cookie' => $cookie]);

            return $this->render('votes_by', ['models' => $models]);
        }

        public function actionRemoveVote($id){
            Vote::findOne($id)
                ->delete();

            return $this->redirect(['votes']);
        }


    }