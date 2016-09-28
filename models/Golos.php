<?php

    namespace app\models;

    use Yii;

    /**
     * This is the model class for table "{{%golos}}".
     *
     * @property integer $id
     * @property string  $about
     * @property integer $date_start
     * @property integer $date_end
     */
    class Golos extends \yii\db\ActiveRecord{
        public $dateS;
        public $dateE;

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%golos}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'about',
                        'dateS',
                        'dateE'
                    ],
                    'required'
                ],
                [
                    ['about'],
                    'string'
                ],
                [
                    [
                        'date_start',
                        'date_end'
                    ],
                    'integer'
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id' => 'ID',
                'about' => 'About',
                'date_start' => 'Date Start',
                'date_end' => 'Date End',
            ];
        }

        public function afterFind(){
            $this->dateS = date('m/d/Y', $this->date_start);
            $this->dateE = date('m/d/Y', $this->date_end);
        }

        public function beforeSave($insert){
            $this->date_start = strtotime($this->dateS);
            $this->date_end = strtotime($this->dateE);

            return parent::beforeSave($insert);
        }

        public static function getActiveGolos(){
            return self::find()
                       ->orderBy(['id' => SORT_DESC])
                       ->limit(1)
                       ->one();
        }
    }
