<?php

    namespace app\controllers;

    use app\models\search\UserSearch;
    use app\models\UserIdentity;
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
                                return Yii::$app->user->identity->role =='admin';
                            }
                        ],
                    ],
                ],
            ];
        }

        public function actionCandidate(){
            $searchUser = new UserSearch(['candidate' => true]);
            $dataProvider = $searchUser->search(Yii::$app->request->queryParams);

            return $this->render('candidate', ['dataProvider' => $dataProvider]);
        }

        public function actionUsers(){
            $searchUser = new UserSearch();
            $dataProvider = $searchUser->search(Yii::$app->request->queryParams);

            return $this->render('users', ['dataProvider' => $dataProvider]);
        }

        public function actionRemoveCandidate($id){
            $model = UserIdentity::findOne($id);
            $model->candidate = 0;
            $model->scenario = 'candidate';
            $model->save();

            return $this->redirect(['candidate']);
        }
    }