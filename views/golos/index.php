<?php

    use app\models\Golos;
    use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Голосования';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="golos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новое Голосование', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Начать новое Голосование', ['activate-new-golos','id'=>Golos::getActiveGolos()->id], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('История голосований', ['history-golos'], ['class' => 'btn btn-info  pull-right']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'about:ntext',
            'date_start:date',
            'date_end:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
