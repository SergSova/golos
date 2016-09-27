<?php
/**
 * @var $this \yii\web\View
 * @var $votes \app\models\Vote[]
 */

?>

<?php foreach($votes as $vote): ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <span><?= $vote->fullNameCandidate ?></span>
            <span class="pull-right"><?= $vote->vote > 0 ? 'за' : 'против' ?></span>
        </div>
        <div class="panel-body">
            <label >Всего голосов: </label>
            <span><?=$vote->candidate->allVote?></span>
        </div>
    </div>
<?php endforeach; ?>
