<?php

    namespace app\controllers;

    use app\models\search\UserSearch;
    use Yii;
    use yii\web\Controller;

    class AdminController extends Controller{

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
    }