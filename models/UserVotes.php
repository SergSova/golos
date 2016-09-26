<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_votes".
 *
 * @property integer $id
 * @property string $f_name
 * @property string $l_name
 * @property string $photo
 * @property string $vote
 */
class UserVotes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_votes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['f_name', 'l_name'], 'required'],
            [['vote'], 'number'],
            [['f_name', 'l_name'], 'string', 'max' => 50],
            [['photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'f_name' => 'Фамилия',
            'l_name' => 'Имя',
            'photo' => 'Фото',
            'vote' => 'Vote',
        ];
    }
}
