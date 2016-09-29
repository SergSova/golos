<?php

    namespace app\models;

    use yii\db\ActiveRecord;

    /**
     * Class Reklama
     * @package app\models
     * @property integer $id
     * @property string  $title
     * @property string  $body
     */
    class Reklama extends ActiveRecord{

        public function rules(){
            return [
                [
                    [
                        'id',
                        'title',
                        'body',
                    ],
                    'safe'
                ],
            ];
        }

    }