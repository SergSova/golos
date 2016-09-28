<?php
    /**
     * @var  $this  \yii\web\View
     * @var  $model \app\models\UserIdentity
     */
    use yii\bootstrap\Html;

?>
<div class="avatar">
    <?= Html::img($model->avatar, ['class' => 'maxi-avatar']) ?>
</div>
<p><label>Login</label>: <?= $model->username ?></p>
<p><label>Имя</label>: <?= $model->f_name ?></p>
<p><label>Фамилия</label>: <?= $model->l_name ?></p>
<p><label>Почта</label>: <?= $model->email ?></p>
<p>
    <label>Участие в голосовании</label>:
    <span class="glyphicon <?= ($model->candidate) ? 'glyphicon-ok text-success' : 'glyphicon-remove text-danger' ?>"></span>
    <?php if($model->candidate != 1 && $model->alafa_register): ?>
        <?= Html::a('Подать заявку', [
            'add-candidate',
            'id' => $model->id
        ], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
</p>
<p>
    <?= Html::a('Сменить аватару', [
        'change-photo',
    ], ['class' => 'btn btn-info']) ?>
</p>
