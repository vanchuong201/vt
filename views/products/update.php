<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $all_status */

$this->title = 'Cập nhật sản phẩm: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="products-update">


    <?= $this->render('_form', [
        'model' => $model,
        'all_status' => $all_status,
    ]) ?>

</div>
