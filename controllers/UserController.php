<?php

    namespace app\controllers;

    use app\models\UserIdentity;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\UploadedFile;

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

            return $this->render('cabinet', ['model' => $model]);
        }

        public function actionChangePhoto(){
            $model = Yii::$app->user->identity;
            if(Yii::$app->request->isPost && $model->uploadPhoto()){
                return $this->redirect(['index']);
            }

            return $this->render('photo');
        }

        public function actionAddCandidate($id){
            $model = UserIdentity::findOne($id);
            if($model->alafa_register){
                $model->candidate = 1;
                $model->scenario = 'candidate';
                $model->save();
            }

            return $this->goBack();
        }
    }