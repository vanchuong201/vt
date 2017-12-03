<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtPerson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vt-person-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cmnd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'don_vi')->textInput() ?>

    <?= $form->field($model, 'chuc_vu')->textInput() ?>

    <?= $form->field($model, 'mon_vo')->textInput() ?>

    <?= $form->field($model, 'dang')->textInput() ?>

    <?= $form->field($model, 'dang_cap')->textInput() ?>

    <?= $form->field($model, 'dai')->textInput() ?>

    <?= $form->field($model, 'cap')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
