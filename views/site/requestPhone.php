<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \app\models\UserIdentity
     */
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;
    use yii\widgets\MaskedInput;

?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
    'mask' => '999999999999',
]) ?>
<?= Html::submitButton('Save') ?>
<?php ActiveForm::end() ?>