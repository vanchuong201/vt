<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\logs\LogsCg;

/* @var $this yii\web\View */
/* @var $searchModel app\models\logs\search\LogsCgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $all_service */

$this->title = 'Lịch sử xác thực tem';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-cg-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'code',
                'value' => function(LogsCg $model){
                    return @$model->serial->serial;
                }
            ],
//            'status_before',
            [
                'class'=>'webvimark\components\StatusColumn',
                'attribute'=>'status_confirm',
                'optionsArray'=>[
                    [LogsCg::CONFIRM_SUCCESS, LogsCg::getStatusConfirm()[LogsCg::CONFIRM_SUCCESS], 'success'],
                    [LogsCg::CONFIRM_FAILED, LogsCg::getStatusConfirm()[LogsCg::CONFIRM_FAILED], 'danger'],
                ],
            ],
//            'code_type',
            [
                'attribute' => 'parcel_id',
                'value' => function(LogsCg $model){
                    return !empty($model->parcel_id) ? @$model->parcel_->name : '';
                },
                'headerOptions' => ['style'=>'width:120px']
            ],
            [
                'attribute' => 'service',
                'value' => function(LogsCg $model) use ($all_service) {
                    return !empty($all_service[$model->service]) ? $all_service[$model->service] : $model->service ;
                }
            ],
            [
                'attribute' => 'product_id',
                'value' => function(LogsCg $model){
                    return !empty($model->product_id) ? @$model->product_->name : '';
                },
                'headerOptions' => ['style'=>'width:150px']
            ],
//            'phone',
//            'device_id',
//            'lat_lng',
//            'user_id',
//            'updated_by',
            [
                'attribute' => 'created_at',
                'value' => function(LogsCg $model){
                    return $model->created_at ? date('H:i | d/m/Y',$model->created_at) : '';
                },
                'headerOptions' => ['style'=>'width:130px']
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
