<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ParcelStamp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parcel-stamp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'service')->dropDownList(Yii::$app->params['all_service']) ?>

    <?= $form->field($model, 'expiry_time')->textInput(['maxlength' => true, 'placeholder'=>'Nhập số ngày bảo hành']) ?>

    <?php // echo $form->field($model, 'status')->textInput() ?>

    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'created_by')->textInput() ?>

    <?php // echo $form->field($model, 'status_zip_excel')->textInput() ?>

    <?php // echo $form->field($model, 'link_excel')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
