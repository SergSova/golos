<?php

    namespace app\models;

    use Yii;
    use yii\web\IdentityInterface;

    /**
     * This is the model class for table "{{%user}}".
     *
     * @property integer  $id
     * @property string   $username
     * @property string   $password
     * @property string   $auth_key
     * @property string   $password_reset_token
     * @property string   $email
     * @property string   $access_token
     * @property string   $f_name
     * @property string   $l_name
     * @property string   $photo
     * @property string   $role
     * @property boolean  $candidate
     *
     * @property Social[] $socials
     */
    class User extends \yii\db\ActiveRecord implements IdentityInterface{
        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%user}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    ['username'],
                    'required'
                ],
                [
                    [
                        'password_reset_token',
                        'role'
                    ],
                    'string'
                ],
                [
                    [
                        'username',
                        'email',
                        'f_name',
                        'l_name'
                    ],
                    'string',
                    'max' => 50
                ],
                [
                    [
                        'password',
                        'auth_key',
                        'access_token',
                        'photo'
                    ],
                    'string',
                    'max' => 255
                ],
                [
                    'candidate',
                    'safe'
                ],
                [
                    'role',
                    'in',
                    'range' => [
                        'user',
                        'admin'
                    ]
                ],
                [
                    ['username'],
                    'unique'
                ],
                [
                    ['email'],
                    'unique'
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
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
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getSocials(){
            return $this->hasMany(Social::className(), ['user_id' => 'id']);
        }

        /**
         * Finds an identity by the given ID.
         *
         * @param string|integer $id the ID to be looked for
         *
         * @return IdentityInterface the identity object that matches the given ID.
         * Null should be returned if such an identity cannot be found
         * or the identity is not in an active state (disabled, deleted, etc.)
         */
        public static function findIdentity($id){
            return self::findOne($id);
        }

        public static function loginByToken($token){
            $s = file_get_contents('http://ulogin.ru/token.php?token='.$token.'&host='.Yii::$app->basePath);
            $token_user = json_decode($s, true);
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!Yii::$app->user->isGuest){
                    $user = Yii::$app->user->identity;
                }else{
                    $user = self::findOne(['email' => $token_user['email']]);
                }
                if(is_null($user)){
                    $user = new self();
                    $user->access_token = $token_user['identity'];
                    $user->email = $token_user['email'];
                    $user->username = $token_user['first_name'].' '.$token_user['last_name'];
                    $user->f_name = $token_user['first_name'];
                    $user->l_name = $token_user['last_name'];
                    $user->setPassword('0');
                    $user->photo = json_encode([$token_user['photo_big']]);
                    $user->role = 'user';

                    if(!$user->save()){
                        throw new \Exception('ошибка сохранения user');
                    }

                    self::addSocial($user, $token_user);
                }else{
                    if(!$user->getSocials()
                             ->where(['social_name' => $token_user['network']])
                             ->exists()
                    ){
                        self::addSocial($user, $token_user);
                    }
                }
                $transaction->commit();
            }catch(\Exception $e){
                $transaction->rollBack();
            }
            /** @var User $user */
            if(!$user->hasErrors()){
                return Yii::$app->user->login($user, 3600 * 24 * 30);
            }

            return false;
        }

        private static function addSocial($user, $token_user){
            $social = new Social();
            $social->user_id = $user->id;
            $social->social_id = $token_user['identity'];
            $social->social_name = $token_user['network'];
            if(!$user->photo && $token_user['photo_big']){
                $user->photo = json_encode([$token_user['photo_big']]);
            }
            if(!$social->save()){
                throw new \Exception('ошибка сохранения social');
            }
        }

        /**
         * Finds an identity by the given token.
         *
         * @param mixed $token the token to be looked for
         * @param mixed $type  the type of the token. The value of this parameter depends on the implementation.
         *                     For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
         *
         * @return IdentityInterface the identity object that matches the given token.
         * Null should be returned if such an identity cannot be found
         * or the identity is not in an active state (disabled, deleted, etc.)
         */
        public static function findIdentityByAccessToken($token, $type = null){
            return self::findOne(['access_token' => $token]);
        }

        /**
         * Returns an ID that can uniquely identify a user identity.
         * @return string|integer an ID that uniquely identifies a user identity.
         */
        public function getId(){
            return $this->id;
        }

        /**
         * Returns a key that can be used to check the validity of a given identity ID.
         *
         * The key should be unique for each individual user, and should be persistent
         * so that it can be used to check the validity of the user identity.
         *
         * The space of such keys should be big enough to defeat potential identity attacks.
         *
         * This is required if [[User::enableAutoLogin]] is enabled.
         * @return string a key that is used to check the validity of a given identity ID.
         * @see validateAuthKey()
         */
        public function getAuthKey(){
            return $this->auth_key;
        }

        /**
         * Validates the given auth key.
         *
         * This is required if [[User::enableAutoLogin]] is enabled.
         *
         * @param string $authKey the given auth key
         *
         * @return boolean whether the given auth key is valid.
         * @see getAuthKey()
         */
        public function validateAuthKey($authKey){
            return $this->auth_key === $authKey;
        }

        public function setPassword($string){
            $this->password = Yii::$app->security->generatePasswordHash($string);
        }

        /**
         * Validates password
         *
         * @param string $password password to validate
         *
         * @return boolean if password provided is valid for current user
         */
        public function validatePassword($password){
            return Yii::$app->security->validatePassword($password, $this->password);
        }

        public static function findByUsername($username){
            return self::findOne(['username' => $username]);
        }
    }