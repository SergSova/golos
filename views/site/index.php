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
    $urlVote = Url::to(['rate/vote'], true);
    $js = <<<JS
var urlVote='{$urlVote}';
$('.candidate-list').css('height', $(window).height()-$('.navbar').height()*2-$('.footer').height());
JS;
    $this->registerJs($js, \yii\web\View::POS_END);
    VoteAsset::register($this);

?>

<div class="row">
    <div class="col-sm-6 candidate-list">
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
            <div class="col-sm-8 liders-block">
                <?php Pjax::begin(['id' => 'liders_block']) ?>
                <p>Топ - 5</p>
                <?php foreach($liders as $model): ?>
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <div class="col-sm-10">
                                <img src="<?= $model->avatar ?>" class="micro-avatar">
                                <?= $model->l_name.' '.$model->f_name ?>
                            </div>
                            <div class="col-sm-2">
                                <div class="row">
                                    <div class="col-sm-4 vote" id="vote-'.<?= $model->id ?>.'"><?= $model->vote ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php Pjax::end() ?>
            </div>
            <div class="col-sm-4 rek-block">reklama</div>
        </div>
    </div>
</div>

