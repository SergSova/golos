<?php

    namespace app\controllers;

    use app\models\forms\LoginForm;
    use app\models\forms\RegistrationForm;
    use app\models\search\UserSearch;
    use app\models\UserIdentity;
    use app\models\UserVotes;
    use Yii;
    use yii\data\ActiveDataProvider;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\web\Cookie;
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
            $session = Yii::$app->session;
            $user_id = Yii::$app->user->isGuest ? Yii::$app->security->generateRandomString() : Yii::$app->user->identity->id;
            $session->set('user_id', $user_id);
            $session->set('t', time());

            $searchUser = new UserSearch(['candidate' => true]);
            $dataProvider = $searchUser->search(Yii::$app->request->queryParams);

            $liders = UserVotes::find()
                               ->where([
                                           'not',
                                           ['vote' => null]
                                       ])
                               ->orderBy(['vote' => SORT_DESC])
                               ->limit(5)
                               ->all();

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'liders' => $liders
            ]);
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
                if($user->save() && Yii::$app->user->login($user, 3600 * 24 * 30)){
                    return $this->redirect(['index']);
                }
            }
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        public function actionLogout(){
            Yii::$app->user->logout();

            return $this->goHome();
        }

        //region verifyPhone
        public function actionRequestPhone($id){
            $model = UserIdentity::findOne($id);
            $model->scenario = 'phone';
            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect(['index']);
            }

            return $this->render('requestPhone', ['model' => $model]);
        }

        public function actionConfirmPhone($id){
            $model = UserIdentity::findOne($id);
            if(Yii::$app->request->post() && $model->validateSMS()){
                $model->confirmSMS = null;
                $model->confirmed = true;
                if($model->save()){
                    return $this->redirect(['index']);
                }
            }

            return $this->render('confirm_sms');
        }
        //endregion

    }
