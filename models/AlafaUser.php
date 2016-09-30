<?php

    namespace app\models;

    use Yii;
    use yii\base\Model;

    /**
     * Class AlafaUser
     * @package app\models
     */
    class AlafaUser extends Model{
        public static function checkExist($email){
            $result = Yii::$app->db2->createCommand('SELECT count(*) as rows FROM customers_users WHERE email="'.$email.'"')
                                    ->queryOne();
            return $result['rows']>0;
        }
    }