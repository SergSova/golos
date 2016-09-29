<?php
    /**
     * @var $this   \yii\web\View
     * @var $models \app\models\Vote[]
     */
    use yii\bootstrap\Html;

?>

<?php foreach($models as $vote): ?>
    <div class="panel panel-success">

        <div class="panel-heading">
            <span><?= $vote->user->fullName ?></span>
            <span class="pull-right"><?= $vote->vote > 0 ? 'за' : 'против' ?></span>
        </div>
        <div class="panel-body">
            <div>
                <label class="text-danger">Голос за: </label>
                <?= $vote->candidate->fullName ?>
            </div>
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
