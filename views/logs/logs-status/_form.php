<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\logs\LogsStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logs-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'code_start')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code_end')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parcel_id')->textInput() ?>

    <?= $form->field($model, 'service')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'device_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lat_lng')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>


    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
