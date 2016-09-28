<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Golos */

$this->title = 'Новое Голосование';
$this->params['breadcrumbs'][] = ['label' => 'Голосования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="golos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
