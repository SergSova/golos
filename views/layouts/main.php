<?php

    /* @var $this \yii\web\View */
    /* @var $content string */

    use app\widgets\MyAlert;
    use yii\helpers\Html;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\helpers\Url;
    use yii\widgets\Breadcrumbs;
    use app\assets\AppAsset;

    AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php
        NavBar::begin([
                          'brandLabel' => '<img src="'.Url::to(['img/alafa.png'], true).'"> Алафа',
                          'brandUrl'   => Yii::$app->homeUrl,
                          'options'    => [
                              'class' => 'navbar-inverse navbar-fixed-top',
                          ],
                      ]);

        $items = [];
        if(Yii::$app->user->isGuest){

            $items[] = [
                'label' => 'Регистрация',
                'url'   => ['/site/login'],
            ];
        }else{
            if(Yii::$app->user->identity->role == 'admin'){
                $items[] = [
                    'label' => 'Реклама',
                    'url'   => ['/reklama/index'],
                ];
                $items[] = [
                    'label' => 'Голосования',
                    'url'   => ['/golos/index'],
                ];
                $items[] = [
                    'label' => 'Кандидаты',
                    'url'   => ['/admin/candidates'],
                ];
                $items[] = [
                    'label' => 'Пользователи',
                    'url'   => ['/admin/users'],
                ];
                $items[] = [
                    'label' => 'Голоса',
                    'url'   => ['/admin/votes'],
                ];
            }
            $items[] = [
                'label' => 'Cabinet',
                'url'   => ['/user/index'],
            ];
            $items[] = '<li>'.Html::beginForm(['/site/logout'], 'post',
                                              ['class' => 'navbar-form']).Html::submitButton('Logout ('.Yii::$app->user->identity->username.')',
                                                                                             ['class' => 'btn btn-link']).Html::endForm().'</li>';
        }

        echo Nav::widget([
                             'options' => Yii::$app->user->isGuest ? ['class' => 'navbar-nav login-btn'] : ['class' => 'navbar-nav navbar-right'],
                             'items'   => $items,
                         ]);
        NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]) ?>
        <?= MyAlert::widget() ?>
        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
