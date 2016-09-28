<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \app\models\GolosResult[]
     */

?>
<?php foreach($model as $item): ?>
    <div class="panel panel-info">
        <p class="panel-heading"><?= $item->golos->about ?></p>
        <p class="panel-heading pull-right">Финиш: <?= $item->golos->dateE ?></p>
        <div class="panel-body">
            <?= $item->result ?>
        </div>
    </div>
<?php endforeach; ?>
