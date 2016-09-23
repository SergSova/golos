<?php
    use yii\bootstrap\Html;

    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl([
                                                              'site/confirmation-email',
                                                              'token' => $user->access_token,
                                                          ]);
?>

    Вы зарегистрировались на сайте <?=Yii::$app->name?>
    <br>
    Для подтверждения почты перейдите по ссылке <?= Html::a(Html::encode($confirmLink), $confirmLink) ?>