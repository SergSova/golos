<?php
    /**
     * @var $this      \yii\web\View
     * @var $candidate \app\models\UserIdentity
     */

    use yii\bootstrap\Html;

    $this->title = $candidate->fullName;
?>

<?php foreach($candidate->votes as $vote): ?>
    <div class="panel panel-success">
        <p class="panel-heading">
            <?= $vote->user->fullName ?>
        </p>
        <div class="panel-body">
            <div>
                <label for="session<?= $vote->id ?>">Сессия пользователя</label>
                <?= Html::a($vote->user_session, [
                    'vote-by-session',
                    'session' => $vote->user_session
                ], ['id' => "session".$vote->id]) ?>
            </div>
            <div>
                <label for="cookie<?= $vote->id ?>">Кука пользователя</label>
                <?= Html::a($vote->user_cookie, [
                    'vote-by-cookie',
                    'cookie' => $vote->user_cookie
                ], ['id' => "cookie".$vote->id]) ?>
            </div>
            <div class="user-info">
                <?php foreach(json_decode($vote->user_info) as $k => $v): ?>
                    <label><?= $k ?></label>
                    <span><?= $v ?></span>
                    <br>
                <?php endforeach; ?>
                <?= Html::a('', [
                    'remove-vote',
                    'id' => $vote->id
                ], [
                                'class' => 'text-danger glyphicon glyphicon-remove pull-right',
                                'data-confirm' => 'точно удалить'
                            ]) ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

