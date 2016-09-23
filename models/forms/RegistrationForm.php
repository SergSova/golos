<?php

    namespace app\models\forms;

    use app\models\User;
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
                        'email'
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
                    'targetClass' => User::className(),
                    'targetAttribute' => ['username' => 'username']
                ],
                [
                    ['email'],
                    'unique',
                    'skipOnError' => true,
                    'targetClass' => User::className(),
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
                $user = new User();
                $user->username = $this->username;
                $user->email = $this->email;
                $user->setPassword($this->password);
                $user->f_name = $this->f_name;
                $user->l_name = $this->l_name;
                $user->photo = json_encode($this->photo);

            }

            return null;
        }
    }

