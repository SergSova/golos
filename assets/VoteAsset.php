<?php

    namespace app\assets;

    use yii\web\AssetBundle;

    class VoteAsset extends AssetBundle{
        public $js      = [
            '/web/js/vote.js'
        ];
        public $depends = [
            'app\assets\AppAsset'
        ];
    }