<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gol_social".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $social_name
 * @property string $social_id
 *
 * @property User $user
 */
class Social extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gol_social';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'social_name', 'social_id'], 'required'],
            [['user_id'], 'integer'],
            [['social_name', 'social_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'social_name' => 'Social Name',
            'social_id' => 'Social ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
