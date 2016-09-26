<?php

    namespace app\controllers;

    use app\models\UserIdentity;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;

    class UserController extends Controller{
        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ];
        }

        public function actionIndex(){
            $model = Yii::$app->user->identity;

            return $this->render('cabinet',['model'=>$model]);
        }

        public function actionAddCandidate($id){
            $model  = UserIdentity::findOne($id);

        }
    }