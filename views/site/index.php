<?php
    /**
     * @var $this           \yii\web\View
     * @var $searchUser     \app\models\search\UserSearch
     * @var $dataProvider   \yii\data\ActiveDataProvider
     * @var $reklama        Reklama[]
     * @var $golos          Golos
     */
    use app\assets\VoteAsset;
    use app\models\Golos;
    use app\models\Reklama;
    use yii\bootstrap\Html;
    use yii\helpers\Url;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;

    $this->title = "Голосовалка";

    $urlVote = Url::to(['rate/vote'], true);
    $js = <<<JS
var urlVote='{$urlVote}';
if($(window).width() > 991){
    if($('div').is($('#cnl'))){
        $('#cnl').height($(window).height() - $('#cnl').offset().top - 30);
    }
    $('#rkb').height($(window).height() - $('#rkb').offset().top - 30);
}
JS;
    $this->registerJs($js, \yii\web\View::POS_END);
    VoteAsset::register($this);

    $golos = Golos::getActiveGolos();
    $reklama = Reklama::find()
                      ->all();
?>
<div class="row">
    <?php if($golos): ?>
    <div class="col-sm-12 col-md-8 golosovalka">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6"><strong>Дата старта: </strong><?= $golos->dateS ?></div>
                    <div class="col-xs-12 col-sm-6 col-md-6"><span class="pull-right"><strong>Дата финиша: </strong><?= $golos->dateE ?></span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <h3><?= $golos->about ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-md-push-6 liders-block">
                <div id="lb">
                    <?php Pjax::begin(['id' => 'liders_block']) ?>
                    <?php if(count($liders)): ?>
                    <p class="text-center font12>Топ - 5</p>
                            <?php foreach($liders as $model): ?>
                                <div class=" panel panel-danger">
                    <div class="panel-body">
                        <div class="col-xs-10 col-md-10">
                            <img src="<?= $model->avatar ?>" class="micro-avatar">
                            <?= Html::encode($model->l_name.' '.$model->f_name) ?>
                        </div>
                        <div class="col-xs-2 col-md-2">
                            <div class="vote" id="vote-'.<?= $model->id ?>.'"><?= $model->vote ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                <?php Pjax::end() ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-md-push-4 rek-block visible-sm visible-xs ">
            <?php foreach($reklama as $rek): ?>
                <div class="panel panel-info">
                    <?= $rek->title ? '<p class="panel-heading">'.$rek->title.'</p>' : '' ?>
                    <p class="panel-body"><?= $rek->body ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if($golos->date_end > time()): ?>
            <div class="col-sm-12 col-md-6 col-md-pull-6 candidate-list" id="cnl">
                <p class="text-center font12">Кандидаты</p>
                <?= ListView::widget([
                                         'dataProvider' => $dataProvider,
                                         'itemView' => '_candidate_item',
                                         'itemOptions' => ['class' => 'test'],
                                         'layout' => '{items}',
                                         'emptyText' => '<p class="alert alert-warning">Кандидаты еще не зарегистрированы</p>'
                                     ]) ?>
            </div>
        <?php else: ?>
            <div class="col-sm-12 col-md-6 col-md-pull-6">
                <p class="alert alert-danger">Голосование закончено <?= date('m/d/Y', $golos->date_end) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
    <div class="col-sm-12 col-md-4 rek-block hidden-sm hidden-xs" id="rkb">
        <?php foreach($reklama as $rek): ?>
            <div class="panel panel-info">
                <?= $rek->title ? '<p class="panel-heading">'.$rek->title.'</p>' : '' ?>
                <p class="panel-body"><?= $rek->body ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-danger text-center col-sm-12 col-md-8">
        <h2>Активные голосования отсутствуют</h2>
    </div>
    <div class="col-sm-12 col-md-4 rek-block hidden-sm hidden-xs" id="rkb">
        <?php foreach($reklama as $rek): ?>
            <div class="panel panel-info">
                <?= $rek->title ? '<p class="panel-heading">'.$rek->title.'</p>' : '' ?>
                <p class="panel-body"><?= $rek->body ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>

