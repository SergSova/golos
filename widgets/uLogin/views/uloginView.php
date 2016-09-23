<?php
    $this->registerJsFile('//ulogin.ru/js/ulogin.js');
    /** @var array $params */
?>
<?php if(Yii::$app->user->isGuest): ?>
    <div id="uLogin"
         x-ulogin-params="display=<?= $params['display'] ?>;fields=<?= $params['fields'] ?>;optional=<?= $params['optional'] ?>;providers=<?= $params['providers'] ?>;hidden=<?= $params['hidden'] ?>;redirect_uri=<?= urlencode($params['redirect']) ?>"></div>

<?php else: ?>
    <?php
    $s = file_get_contents('http://ulogin.ru/token.php?token='.$_POST['token'].'&host='.$_SERVER['HTTP_HOST']);
    $user = json_decode($s, true);
    // $user['network'] - соц. сеть, через которую авторизовался пользователь
    //$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
    //$user['first_name'] - имя пользователя
    //$user['last_name'] - фамилия пользователя
    echo $user['network'];
    echo $user['identity'];
    echo $user['first_name'];
    echo $user['last_name'];
    ?>

<?php endif; ?>