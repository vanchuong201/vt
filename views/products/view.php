<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Products;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $all_status */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">


    <p>
        <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Xóa sản phẩm', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id',
                'visible' => Yii::$app->user->isAdminGroup,
            ],
            'name',
            'short_description:ntext',
            'description:ntext',
            'image:ntext',
            'gtin',
            [
                'attribute' => 'user_id',
                'value' => function(Products $model){
                    return $model->user_->full_name;
                },
                'visible' => Yii::$app->user->isAdminGroup,
            ],
            [
                'attribute' => 'status',
                'value' => function(Products $model) use ($all_status){
                    return $all_status[$model->status];
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function(Products $model){
                    return date('H:i', $model->created_at).'&nbsp;&nbsp;'.date('d/m/Y', $model->created_at);
                }
            ],
            [
                'attribute' => 'created_by',
                'value' => function(Products $model){
                    return $model->user__->full_name ? $model->user__->full_name : $model->user__->username;
                },
            ],
        ],
    ]) ?>

</div>
