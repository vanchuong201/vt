<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searchs\StampsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stamps-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code_id') ?>

    <?= $form->field($model, 'serial') ?>

    <?= $form->field($model, 'qrm') ?>

    <?= $form->field($model, 'code_sms') ?>

    <?php // echo $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'user_scan') ?>

    <?php // echo $form->field($model, 'device_id') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'geo_location') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'district') ?>

    <?php // echo $form->field($model, 'to_city') ?>

    <?php // echo $form->field($model, 'to_district') ?>

    <?php // echo $form->field($model, 'to_address') ?>

    <?php // echo $form->field($model, 'active_time') ?>

    <?php // echo $form->field($model, 'own_product') ?>

    <?php // echo $form->field($model, 'sim_manage') ?>

    <?php // echo $form->field($model, 'expire_time') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'stamp_service') ?>

    <?php // echo $form->field($model, 'counter') ?>

    <?php // echo $form->field($model, 'current_counter') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
