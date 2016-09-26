<?php
    /**
     * @var $this         \yii\web\View
     * @var $searchUser   \app\models\search\UserSearch
     * @var $dataProvider \yii\data\ActiveDataProvider
     */
    use app\assets\VoteAsset;
    use app\commands\SMSClient;
    use yii\helpers\Url;
    use yii\widgets\ListView;

    $urlUp = Url::to(['rate/up-vote'], true);
    $urlDown = Url::to(['rate/down-vote'], true);
    $js = <<<JS
var urlVoteUp='{$urlUp}';
var urlVoteDown='{$urlDown}';
JS;
    $this->registerJs($js, \yii\web\View::POS_END);
    VoteAsset::register($this);

?>

<?= ListView::widget([
                         'dataProvider' => $dataProvider,
                         'itemView' => '_candidate_item',
                         'itemOptions' => ['class' => 'test']
                     ]) ?>
