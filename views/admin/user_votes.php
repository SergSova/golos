<?php
    /**
     * @var $this  \yii\web\View
     * @var $votes \app\models\Vote[]
     */
    use yii\bootstrap\Html;

?>

<?php foreach($votes as $vote): ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <span><?= $vote->candidate->fullName ?></span>
            <span class="pull-right"><?= $vote->vote > 0 ? 'за' : 'против' ?></span>
        </div>
        <div class="panel-body">
            <label>Всего голосов: </label>
            <span><?= $vote->candidate->allVote ?></span>
            <?= Html::a('', [
                'remove-vote',
                'id' => $vote->id
            ], [
                            'class' => 'text-danger glyphicon glyphicon-remove pull-right',
                            'data-confirm' => 'точно удалить'
                        ]) ?>
        </div>

    </div>

<?php endforeach; ?>
