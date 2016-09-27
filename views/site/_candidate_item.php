<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \app\models\UserIdentity
     */

    $cookies = Yii::$app->request->cookies;
    $visible = \app\models\Vote::find()
                               ->where([
                                           'candidate_id' => $model->id,
                                           'user_cookie' => $cookies->get('user_cookie')->value
                                       ])
                               ->exists();
?>

<div class="panel panel-danger">
    <div class="panel-body">
        <div class="col-sm-10">
            <?= $model->l_name.' '.$model->f_name ?>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-4 "><?= $visible ? '' : "<span class='text-success glyphicon glyphicon-thumbs-up upvote'></span>" ?></div>
                <div class="col-sm-4 vote" id="vote-'.<?=$model->id?>.'"><?= $model->allVote ?></div>
                <div class="col-sm-4 "><?= $visible ? '' : "<span class='text-danger glyphicon glyphicon-thumbs-down downvote'></span>" ?></div>
            </div>
        </div>
    </div>
</div>
