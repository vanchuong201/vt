<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\search\VtPersonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vt-person-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_card') ?>

    <?= $form->field($model, 'full_name') ?>

    <?= $form->field($model, 'birthday') ?>

    <?= $form->field($model, 'cmnd') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'don_vi') ?>

    <?php // echo $form->field($model, 'chuc_vu') ?>

    <?php // echo $form->field($model, 'mon_vo') ?>

    <?php // echo $form->field($model, 'dang') ?>

    <?php // echo $form->field($model, 'dang_cap') ?>

    <?php // echo $form->field($model, 'dai') ?>

    <?php // echo $form->field($model, 'cap') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
