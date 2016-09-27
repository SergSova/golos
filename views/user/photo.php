<?php
    /**
     * @var $this \yii\web\View
     *
     */
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;

?>

<?php ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?= Html::fileInput('photo', __FILE__) ?>
<?= Html::submitButton('Сохранить') ?>
<?php ActiveForm::end() ?>
