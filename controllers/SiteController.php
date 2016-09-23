<?php

    namespace app\controllers;

    use app\models\forms\LoginForm;
    use app\models\forms\RegistrationForm;
    use app\models\UserIdentity;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\web\NotFoundHttpException;

    class SiteController extends Controller{
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['logout'],
                    'rules' => [
                        [
                            'actions' => ['logout'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function actions(){
            return [
                'error' => [
                    'class' => 'yii\web\ErrorAction',
                ],
            ];
        }

        public function beforeAction($action){
            if($action->id == 'registration' || $action->id == 'login'){
                $this->enableCsrfValidation = false;
            }

            return parent::beforeAction($action);
        }

        /**
         * Displays homepage.
         *
         * @return string
         */
        public function actionIndex(){
            return $this->render('index');
        }

        public function actionLogin(){
            if(!Yii::$app->user->isGuest){
                return $this->goHome();
            }

            $token = Yii::$app->request->post('token');
            if(isset($token) && UserIdentity::loginByToken($token)){
                return $this->goBack();
            }

            $model = new LoginForm();
            if($model->load(Yii::$app->request->post()) && $model->login()){
                return $this->goBack();
            }

            return $this->render('login', [
                'model' => $model,
            ]);
        }

        public function actionRegistration(){
            $model = new RegistrationForm();
            if($model->load(Yii::$app->request->post()) && $model->register()){
                return $this->goBack();
            }

            return $this->render('registration', [
                'model' => $model,
            ]);
        }

        public function actionConfirmationEmail($token){
            $user = UserIdentity::findIdentityByAccessToken($token);
            if($user){
                $user->access_token = null;
                $user->confirmed = true;
                if($user->save()&&Yii::$app->user->login($user, 3600 * 24 * 30)){
                    $this->goHome();
                }
            }
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        public function actionLogout(){
            Yii::$app->user->logout();

            return $this->goHome();
        }


    }
