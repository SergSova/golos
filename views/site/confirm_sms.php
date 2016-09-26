<?php
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;

?>

<?php $form = ActiveForm::begin() ?>
<?= Html::textInput('phone', '') ?>
<?= Html::submitButton('send') ?>
<?php ActiveForm::end() ?>
