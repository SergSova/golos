<?php
    /**
     * @var $this         \yii\web\View
     * @var $dataProvider \yii\data\ActiveDataProvider
     */

    use yii\grid\GridView;

    $this->title = 'Users';
?>


<?= GridView::widget(['dataProvider' => $dataProvider]) ?>