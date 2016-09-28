<?php

    use yii\bootstrap\Html;

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
//        'role',
        'f_name',
        'l_name',
        [
            'attribute' => 'candidate',
            'content' => function($model){
                return '<span class="glyphicon '.(($model->candidate) ? 'glyphicon-ok' : 'glyphicon-remove').'"></span>';
            }
        ],
        ['label'=>'Удалить',
         'content'=>function($model){
            return Html::a('',['admin/remove-candidate','id'=>$model->id],['class'=>'text-danger glyphicon glyphicon-remove']);
         }
        ],
        ['content'=>function($model){
            return Html::a('Просмотреть',['admin/candidate-votes','id'=>$model->id],['class'=>'btn btn-danger']);
        }]

    ]

?>

<?=\yii\grid\GridView::widget(['dataProvider'=>$dataProvider,
                               'columns' => $columns])?>
