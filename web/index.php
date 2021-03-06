<?php

    // comment out the following two lines when deployed to production
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');

    require(__DIR__.'/../vendor/autoload.php');
    require(__DIR__.'/../vendor/yiisoft/yii2/Yii.php');

    Yii::setAlias('@mail', __DIR__.'/../mail/');
    Yii::setAlias('@basePath',__DIR__.'/storage');
    Yii::setAlias('@baseUrl','http://golosovalka.local');

    $config = yii\helpers\ArrayHelper::merge(require(__DIR__.'/../config/web.php'), require(__DIR__.'/../config/web_local.php'));

    (new yii\web\Application($config))->run();


