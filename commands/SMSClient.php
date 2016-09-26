<?php

    namespace app\commands;

    use app\models\UserIdentity;
    use Yii;
    use yii\base\Object;

    class SMSClient extends Object{
        public $model;
        public $to;

        public function sendSMS(UserIdentity $model){
            if(!$model->confirmed && !$model->confirmSMS){
                if($model->phone == '+380(00)000-00-00' || empty($model->phone)){
                    return Yii::$app->controller->redirect([
                                                               'site/request-phone',
                                                               'id' => $model->id
                                                           ]);
                }
                $model->getSmsConfim();
                $_sMStext = 'https://gate.smsclub.mobi/http/?username='.Yii::$app->params['SMSLogin'].'&password='.Yii::$app->params['SMSPassword'].'&from='.Yii::$app->params['SMSAlfaName'].'&to='.$model->phone.'&text='.$model->confirmSMS;

                $ch = curl_init($_sMStext);
                $result = curl_exec($ch);
                if($result && $model->save()){
                    return Yii::$app->controller->redirect([
                                                               'site/confirm-phone',
                                                               'id' => $model->id
                                                           ]);
                }
            }

            return false;
        }

        public function resendSMS(UserIdentity $model){
            if(!$model->confirmed){
                if($model->phone == '+380(00)000-00-00' || empty($model->phone)){
                    return Yii::$app->controller->redirect([
                                                               'site/request-phone',
                                                               'id' => $model->id
                                                           ]);
                }
                $model->getSmsConfim();
                $_sMStext = 'https://gate.smsclub.mobi/http/?username='.Yii::$app->params['SMSLogin'].'&password='.Yii::$app->params['SMSPassword'].'&from='.Yii::$app->params['SMSAlfaName'].'&to='.$model->phone.'&text='.$model->confirmSMS;

                $ch = curl_init($_sMStext);
                $result = curl_exec($ch);
                if($result && $model->save()){
                    return Yii::$app->controller->redirect([
                                                               'site/confirm-phone',
                                                               'id' => $model->id
                                                           ]);
                }
            }
            return false;
        }


    }
