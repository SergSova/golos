<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Reklama */

$this->title = 'Create Reklama';
$this->params['breadcrumbs'][] = ['label' => 'Reklamas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reklama-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
