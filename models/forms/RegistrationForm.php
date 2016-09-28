<?php

    namespace app\models\forms;

    use app\models\AlafaUser;
    use app\models\UserIdentity;
    use Yii;
    use yii\base\Model;

    class RegistrationForm extends Model{

        public $username;
        public $email;
        public $access_token;
        public $password;
        public $password_repeat;
        public $f_name;
        public $l_name;
        public $photo;

        public function rules(){
            return [
                [
                    [
                        'username',
                        'password',
                        'email',
                        'l_name',
                        'f_name'
                    ],
                    'required'
                ],
                [
                    'photo',
                    'safe'
                ],
                [
                    ['username'],
                    'unique',
                    'skipOnError' => true,
                    'targetClass' => UserIdentity::className(),
                    'targetAttribute' => ['username' => 'username']
                ],
                [
                    ['email'],
                    'unique',
                    'skipOnError' => true,
                    'targetClass' => UserIdentity::className(),
                    'targetAttribute' => ['email' => 'email']
                ],
                [
                    'email',
                    'email'
                ],
                [
                    [
                        'email',
                        'password',
                        'password_repeat',
                        'username'
                    ],
                    'trim'
                ],
                [
                    'password',
                    'compare'
                ],
            ];
        }

        public function attributeLabels(){
            return [
                'username' => 'Ваш логин',
                'email' => 'Ваш Email',
                'password' => 'Подтвердите пароль',
                'password_repeat' => 'Ваш пароль',
                'photo' => 'Аватар',
                'f_name' => 'Фамилия',
                'l_name' => 'Имя',

            ];
        }

        public function register(){
            if($this->validate()){
                $user = new UserIdentity();
                $user->scenario = 'register';
                $user->attributes = $this->attributes;
                $user->setPassword($this->password);
                $user->alafa_register = AlafaUser::checkExist($this->email);
                $user->access_token = Yii::$app->security->generateRandomString();
                if($user->save()){
                    return Yii::$app->mailer->compose([
                                                          'html' => 'confirmation-email-html',
                                                          'text' => 'confirmation-email-text',
                                                      ], [
                                                          'user' => $user
                                                      ])
                                            ->setFrom(Yii::$app->params['supportEmail'])
                                            ->setTo($user->email)
                                            ->setSubject('Подтверждение почты')
                                            ->send();
                }
            }

            return null;
        }
    }

