<?php
    /**
     * @var $this         \yii\web\View
     * @var $dataProvider \yii\data\ActiveDataProvider
     */

    use yii\bootstrap\Html;
    use yii\grid\GridView;

    $this->title = 'Users';
    $columns = [
        ['class' => \yii\grid\SerialColumn::className()],
        'username',
        'email',
        [
            'attribute' => 'confirmed',
            'content' => function($model){
                return '<span class="glyphicon '.(($model->confirmed) ? 'glyphicon-ok' : 'glyphicon-remove').'"></span>';
            }
        ],
        'role',
        'f_name',
        'l_name',
        [
            'attribute' => 'candidate',
            'content' => function($model){
                return '<span class="glyphicon '.(($model->candidate) ? 'glyphicon-ok' : 'glyphicon-remove').'"></span>';
            }
        ],
        [
            'content' => function($model){
                return Html::a('Просмотреть',['user-votes','id'=>$model->id],['class'=>'btn btn-info']);
            }
        ],

    ]
?>


<?= GridView::widget([
                         'dataProvider' => $dataProvider,
                         'columns' => $columns,
                     ]) ?>