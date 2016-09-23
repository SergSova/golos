<?php

    namespace app\models;

    use Yii;
    use yii\helpers\ArrayHelper;
    use yii\web\IdentityInterface;

    class UserIdentity extends User implements IdentityInterface{

        public function getAllVote(){
            return $this->getVotes()
                        ->where(['vote' => true])
                        ->count() - $this->getVotes()
                                         ->where(['vote' => false])
                                         ->count();
        }

        public function scenarios(){
            $scenario = [
                'filter' => [
                    'username',
                    'email',
                    'f_name',
                    'l_name',
                    'candidate',
                ],
                'register' => [
                    'username',
                    'email',
                    'photo',
                    'f_name',
                    'l_name',
                ]
            ];

            return ArrayHelper::merge(parent::scenarios(), $scenario);
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
            /** @var UserIdentity $user */
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
         * @param mixed $token
         * @param null  $type
         *
         * @return null|UserIdentity
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
