<?php

    namespace app\controllers;

    use app\models\GolosResult;
    use app\models\UserIdentity;
    use app\models\UserVotes;
    use app\models\Vote;
    use Yii;
    use app\models\Golos;
    use app\models\search\EventSearch;
    use yii\data\ActiveDataProvider;
    use yii\filters\AccessControl;
    use yii\helpers\ArrayHelper;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * GolosController implements the CRUD actions for Golos model.
     */
    class GolosController extends Controller{
        /**
         * @inheritdoc
         */
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
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }

        /**
         * Lists all Golos models.
         * @return mixed
         */
        public function actionIndex(){

            $dataProvider = new ActiveDataProvider([
                                                       'query' => Golos::find()
                                                   ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single Golos model.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionView($id){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

        /**
         * Creates a new Golos model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate(){
            $model = new Golos();

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->id
                                       ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing Golos model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate($id){
            $model = $this->findModel($id);

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->redirect([
                                           'view',
                                           'id' => $model->id
                                       ]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing Golos model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionDelete($id){
            $this->findModel($id)
                 ->delete();

            return $this->redirect(['index']);
        }

        /**
         * Finds the Golos model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return Golos the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id){
            if(($model = Golos::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        public function actionActivateNewGolos($id){
            $result = new GolosResult();
            $candidate = UserIdentity::find()
                                     ->where(['candidate' => 1])
                                     ->all();
            $vote_count = Vote::find()
                              ->count();
            $liders = UserIdentity::findAll([
                                                'id' => UserVotes::find()
                                                                 ->where([
                                                                             'not',
                                                                             ['vote' => null]
                                                                         ])
                                                                 ->orderBy(['vote' => SORT_DESC])
                                                                 ->limit(5)
                                                                 ->select('id')
                                                                 ->all()
                                            ]);
            $tmp = [];
            $tmp['vote_count'] = $vote_count;
            $tmp['liders'] = ArrayHelper::map($liders, 'fullName', 'allVote');
            $tmp['candidates'] = ArrayHelper::map($candidate, 'fullName', 'allVote');
            $result->golos_id = $id;
            $result->result = json_encode($tmp);
            if($result->save()){
                Vote::deleteAll();
                foreach($candidate as $item){
                    $item->candidate = 0;
                    $item->save();
                }
            }

            return $this->goHome();
        }

        public function actionHistoryGolos(){
            return $this->render('history_golos', [
                'model' => GolosResult::find()
                                      ->all()
            ]);
        }
    }
