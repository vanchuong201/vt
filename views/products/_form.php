<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vid')->textInput() ?>

    <?= $form->field($model, 'gtin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gln')->textInput(['maxlength' => true]) ?>

    <?= Yii::$app->user->isSuperadmin ? $form->field($model, 'user_id')->textInput() : null ?>

    <?php if ( !$model->isNewRecord ): ?>
    <?= $form->field($model, 'status')->textInput() ?>
    <?php endif; ?>

<!--    --><?php //echo $form->field($model, 'created_at')->textInput() ?>
<!---->
<!--    --><?php //echo $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
