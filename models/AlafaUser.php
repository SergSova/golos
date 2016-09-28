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
            return Yii::$app->db2->createCommand('SELECT count(*) FROM customers_users WHERE email="'.$email.'"')
                                 ->queryOne()>0;
        }
    }