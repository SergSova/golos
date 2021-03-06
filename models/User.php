<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $email
 * @property string $access_token
 * @property string $f_name
 * @property string $l_name
 * @property string $photo
 * @property string $role
 * @property integer $candidate
 * @property integer $alafa_register
 * @property integer $confirmed
 * @property string $phone
 * @property integer $confirmSMS
 *
 * @property Social[] $socials
 * @property Vote[] $votes
 * @property Vote[] $votes0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'f_name', 'l_name'], 'required'],
            [['password_reset_token', 'role'], 'string'],
            [['candidate', 'alafa_register', 'confirmed', 'confirmSMS'], 'integer'],
            [['username', 'email', 'f_name', 'l_name'], 'string', 'max' => 50],
            [['password', 'auth_key', 'access_token', 'photo'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 25],
            [['email'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'access_token' => 'Access Token',
            'f_name' => 'Фамилия',
            'l_name' => 'Имя',
            'photo' => 'Фото',
            'role' => 'Role',
            'candidate' => 'Candidate',
            'alafa_register' => 'Alafa Register',
            'confirmed' => 'Confirmed',
            'phone' => 'Phone',
            'confirmSMS' => 'Confirm Sms',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocials()
    {
        return $this->hasMany(Social::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return $this->hasMany(Vote::className(), ['candidate_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes0()
    {
        return $this->hasMany(Vote::className(), ['user_id' => 'id']);
    }
}
