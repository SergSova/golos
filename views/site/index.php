<?php
    /**
     * @var $this         \yii\web\View
     * @var $searchUser   \app\models\search\UserSearch
     * @var $dataProvider \yii\data\ActiveDataProvider
     * @var $reklama      Reklama
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
    $('#cnl').height($(window).height() - $('#cnl').offset().top - 100);

}
JS;
    $this->registerJs($js, \yii\web\View::POS_END);
    VoteAsset::register($this);
    $golos = Golos::getActiveGolos();
    $reklama = Reklama::find()
                      ->all();

    mail('sergsova@ukr.net', 'test', 'text');
?>
<?php if($golos): ?>
    <div class="row">
        <div class="col-sm-12 col-md-8 golosovalka">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <strong>Дата старта: </strong><?= $golos->dateS ?>
                    <p class="pull-right"><strong>Дата финиша: </strong><?= $golos->dateE ?></p>
                </div>
                <div class="panel-body">
                    <h3><?= $golos->about ?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-md-push-6 liders-block">
                    <div id="lb">
                        <?php Pjax::begin(['id' => 'liders_block']) ?>
                        <p>Топ - 5</p>
                        <?php foreach($liders as $model): ?>
                            <div class="panel panel-danger">
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
                        <?php Pjax::end() ?>
                    </div>
                    <p></p>
                </div>
                <div class="col-sm-12 col-md-4 col-md-push-4 rek-block visible-sm">
                    <?php foreach($reklama as $rek): ?>
                        <div class="panel panel-info">
                            <?= $rek->title ? '<p class="panel-heading">'.$rek->title.'</p>' : '' ?>
                            <p class="panel-body"><?= $rek->body ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-sm-12 col-md-6 col-md-pull-6 candidate-list" id="cnl"><p>Кандидаты</p>
                    <?= ListView::widget([
                                             'dataProvider' => $dataProvider,
                                             'itemView' => '_candidate_item',
                                             'itemOptions' => ['class' => 'test'],
                                             'layout' => '{items}',
                                             'emptyText' => '<p class="alert alert-warning">Кандидаты еще не зарегистрированы</p>'
                                         ]) ?></div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 rek-block hidden-sm">
            <?php foreach($reklama as $rek): ?>
                <div class="panel panel-info">
                    <?= $rek->title ? '<p class="panel-heading">'.$rek->title.'</p>' : '' ?>
                    <p class="panel-body"><?= $rek->body ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-danger text-center">
        <h2>Активные голосования отсутствуют</h2>
    </div>
<?php endif; ?>

