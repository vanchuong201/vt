<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $all_status */

$this->title = 'Tạo sản phẩm mới';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">


    <?= $this->render('_form', [
        'model' => $model,
        'all_status'=>$all_status
    ]) ?>

</div>
