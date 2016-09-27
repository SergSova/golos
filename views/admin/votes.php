<?php
    /**
     * @var $this         \yii\web\View
     * @var $dataProvider \yii\data\ActiveDataProvider
     * @var $searchVote   \app\models\search\VoteSearch
     */
    use yii\bootstrap\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;

    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'user',
            'content' => function($model){
                return $model->user->f_name.' '.$model->user->l_name;
            }
        ],
        [
            'attribute' => 'vote',
            'content' => function($model){
                return $model->vote > 0 ? 'за' : 'против';
            }
        ],
        [
            'attribute' => 'candidate',
            'content' => function($model){
                return $model->candidate->f_name.' '.$model->candidate->l_name;
            }
        ],
        'user_cookie',
        'user_session',
        [
            'attribute' => 'user_info',
            'content' => function($model){
                $info = json_decode($model->user_info);
                $result = '';
                foreach($info as $k => $v){
                    $result .= '<label>'.$k.'</label> <span>'.$v.'</span><br>';
                }

                return $result;
            }
        ],
        [
            'content' => function($model){
                return Html::a('удалить', ['remove-vote','id'=>$model->id], ['data-confirm' => 'точно удалить']);
            }
        ]
    ];
?>
<?php Pjax::begin(['enablePushState' => false]) ?>
<?= GridView::widget([
                         'dataProvider' => $dataProvider,
                         'filterModel' => $searchVote,
                         'columns' => $columns
                     ]) ?>
<?php Pjax::end() ?>
