<?php

    namespace app\assets;

    use yii\web\AssetBundle;

    class MaterialBoxAsset extends AssetBundle{
        public $css      = [
            'css/materialbox.css'
        ];
        public $js      = [
            'js/velocity.min.js',
            'js/materialbox.js'
        ];
        public $depends = [
            'app\assets\AppAsset'
        ];
    }