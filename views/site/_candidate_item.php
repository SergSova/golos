<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \app\models\UserIdentity
     */
    use yii\bootstrap\Html;

?>

<div class="panel panel-danger">
    <div class="panel-body">
        <div class="col-sm-11">
            <?= $model->l_name.' '.$model->f_name ?>
        </div>
        <div class="col-sm-1">
            <div class="row">
                <div class="col-sm-4"><span class = 'text-success glyphicon glyphicon-thumbs-up upvote'></span></div>
                <div class="col-sm-4 vote"><?= $model->allVote ?></div>
                <div class="col-sm-4"><span class = 'text-danger glyphicon glyphicon-thumbs-down downvote'></span></div>
            </div>
        </div>
    </div>
</div>
