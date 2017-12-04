<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Products;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $all_status */

$this->title = 'Danh sách sản phẩm';
Yii::$app->view->params['description'] = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tạo sản phẩm', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions' => ['style' => 'width:10px'],
                'visible' => Yii::$app->user->isAdminGroup,
            ],
            'name',
            'short_description:text',
            'gtin',
            [
                'attribute' => 'user_id',
                'value' => function(Products $model){
                    return $model->user_->full_name;
                },
                'visible' => Yii::$app->user->isAdminGroup,
            ],
            [
                'class'=>'webvimark\components\StatusColumn',
                'attribute'=>'status',
                'optionsArray'=>[
                    [Products::PRODUCT_INACTIVE, $all_status[Products::PRODUCT_INACTIVE], 'warning'],
                    [Products::PRODUCT_ACTIVE, $all_status[Products::PRODUCT_ACTIVE], 'success'],
                    [Products::PRODUCT_DELETED, $all_status[Products::PRODUCT_DELETED], 'danger'],
                    [Products::PRODUCT_HIDDEN, $all_status[Products::PRODUCT_HIDDEN], 'warning'],
                ],
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function(Products $model){
                    return date('H:i', $model->created_at).' | '.date('d/m/Y', $model->created_at);
                }
            ],
            [
                'attribute' => 'created_by',
                'value' => function(Products $model){
                    return $model->user__->full_name ? $model->user__->full_name : $model->user__->username;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:70px'],
            ],
        ],
    ]); ?>
</div>
