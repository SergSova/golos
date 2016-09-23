<?php

    namespace app\assets;

    use yii\web\AssetBundle;

    class VoteAsset extends AssetBundle{
        public $js      = [
            'js/vote.js'
        ];
        public $depends = [
            'app\assets\AppAsset'
        ];
    }