<?php
    /**
     * @var  $this  \yii\web\View
     * @var  $model \app\models\UserIdentity
     */
    use yii\bootstrap\Html;

?>

<p><?= $model->username ?></p>
<p><?= $model->f_name ?></p>
<p><?= $model->l_name ?></p>
<p>
    <span class="glyphicon <?= ($model->candidate) ? 'glyphicon-ok' : 'glyphicon-remove' ?>"></span>
    <?= Html::a('Подать заявку', [
        'add-candidate',
        'id' => $model->id
    ],['class'=>'btn btn-primary']) ?>
</p>

