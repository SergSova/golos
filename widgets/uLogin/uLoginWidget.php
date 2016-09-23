<?php

    namespace app\widgets\uLogin;

    use yii\base\Widget;

    class uLoginWidget extends Widget{
        private $params;
        public  $redirect;

        public function init(){
            parent::init();
            $this->params = [
                'display' => 'panel',
                'fields' => 'first_name,last_name,email,photo_big',
                'optional' => '',
                'providers' => 'vkontakte,odnoklassniki,mailru,facebook',
                'hidden' => 'twitter,google,yandex,livejournal,openid,lastfm,linkedin,liveid,soundcloud,steam',
                'redirect' => $this->redirect
            ];
        }

        public function run(){
            return $this->render('uloginView', ['params' => $this->params]);
        }
    }