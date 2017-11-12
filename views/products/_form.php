<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
/* @var $all_status */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vid')->textInput() ?>

    <?= $form->field($model, 'gtin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gln')->textInput(['maxlength' => true]) ?>

    <?= Yii::$app->user->isAdminGroup ? $form->field($model, 'user_id')->textInput() : null ?>

    <?php if ( !$model->isNewRecord && Yii::$app->user->isAdminGroup ): ?>
    <?= $form->field($model, 'status')->dropDownList($all_status) ?>
    <?php endif; ?>

<!--    --><?php //echo $form->field($model, 'created_at')->textInput() ?>
<!---->
<!--    --><?php //echo $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
