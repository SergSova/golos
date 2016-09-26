<?php
    /**
     * @var $this         \yii\web\View
     * @var $searchUser   \app\models\search\UserSearch
     * @var $dataProvider \yii\data\ActiveDataProvider
     */
    use app\assets\VoteAsset;
    use yii\helpers\Url;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;

    $this->title = "Голосовалка";
    $urlUp = Url::to(['rate/up-vote'], true);
    $urlDown = Url::to(['rate/down-vote'], true);
    $js = <<<JS
var urlVoteUp='{$urlUp}';
var urlVoteDown='{$urlDown}';
JS;
    $this->registerJs($js, \yii\web\View::POS_END);
    VoteAsset::register($this);

?>

<div class="row">
    <div class="col-sm-6">
        <p>Кандидаты</p>
        <?= ListView::widget([
                                 'dataProvider' => $dataProvider,
                                 'itemView' => '_candidate_item',
                                 'itemOptions' => ['class' => 'test'],
                                 'layout' => '{items}'
                             ]) ?>
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-8">
                <?php Pjax::begin(['id'=>'liders_block'])?>
                <p>Топ - 5</p>
                <?php foreach($liders as $model): ?>
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <div class="col-sm-10">
                                <?= $model->l_name.' '.$model->f_name ?>
                            </div>
                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-4 vote" id="vote-'.<?=$model->id?>.'"><?= $model->vote ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php Pjax::end()?>
            </div>
            <div class="col-sm-4">reklama</div>
        </div>
    </div>
</div>

