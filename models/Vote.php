<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%vote}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $vote
 * @property integer $candidate_id
 * @property string $user_cookie
 * @property string $user_session
 * @property string $user_info
 *
 * @property User $candidate
 * @property User $user
 */
class Vote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vote}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'vote', 'candidate_id'], 'integer'],
            [['vote', 'candidate_id', 'user_cookie', 'user_session'], 'required'],
            [['user_info'], 'string'],
            [['user_cookie', 'user_session'], 'string', 'max' => 150],
            [['user_id', 'candidate_id', 'user_session', 'user_cookie'], 'unique', 'targetAttribute' => ['user_id', 'candidate_id', 'user_session', 'user_cookie'], 'message' => 'The combination of User ID, Candidate ID, User Cookie and User Session has already been taken.'],
            [['candidate_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['candidate_id' => 'id']],
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
            'vote' => 'Vote',
            'candidate_id' => 'Candidate ID',
            'user_cookie' => 'User Cookie',
            'user_session' => 'User Session',
            'user_info' => 'User Info',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCandidate()
    {
        return $this->hasOne(User::className(), ['id' => 'candidate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
