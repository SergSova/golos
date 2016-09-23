<?php
    /**
     * @var $this         \yii\web\View
     * @var $dataProvider \yii\data\ActiveDataProvider
     */

    use yii\grid\GridView;

    $this->title = 'Users';
    $columns = [
        ['class' => \yii\grid\SerialColumn::className()],
        'username',
        'email',
        [
            'attribute' => 'confirmed',
            'content' => function($model){
                return '<span class="glyphicon '.(($model->candidate) ? 'glyphicon-ok' : 'glyphicon-remove').'"></span>';
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

    ]
?>


<?= GridView::widget([
                         'dataProvider' => $dataProvider,
                         'columns' => $columns,
                     ]) ?>