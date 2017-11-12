<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\logs\LogsStatus;
use app\models\Stamps;

/* @var $this yii\web\View */
/* @var $searchModel app\models\logs\search\LogsStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $all_service */
/* @var $all_status */

$this->title = 'Lịch sử thay đổi trạng thái tem';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-status-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'code_start',
//            'code_end',
            [
                'attribute' => 'serial',
                'value' => function(LogsStatus $model){
                    $serial_0 = !empty($model->code_start) ? $model->serialStart->serial : false;
                    $serial_1 = !empty($model->code_end) ? $model->serialEnd->serial : false;
                    if($serial_0 && $serial_1){
                        $serial = $serial_0 . ' đến ' .$serial_1;
                    }else{
                        $serial = $serial_0.$serial_1;
                    }
                    return $serial;

                },
                'contentOptions' => ['style'=>'width:180px']
            ],
            [
                'attribute' => 'parcel_id',
                'value' => function(LogsStatus $model){
                    return !empty($model->parcel_id) ? @$model->parcel_->name : '';
                },
                'headerOptions' => ['style'=>'width:120px']
            ],
            [
                'attribute' => 'service',
                'value' => function(LogsStatus $model) use ($all_service) {
                    return !empty($all_service[$model->service]) ? $all_service[$model->service] : $model->service ;
                }
            ],
            [
                'class'=>'webvimark\components\StatusColumn',
                'attribute'=>'status',
                'optionsArray'=>[
                    [Stamps::INACTIVE, $all_status[Stamps::INACTIVE], 'default'],
                    [Stamps::ACTIVE_FOR_RELEASE, $all_status[Stamps::ACTIVE_FOR_RELEASE], 'success'],
                    [Stamps::SOLD_OUT, $all_status[Stamps::SOLD_OUT], 'primary'],
                    [Stamps::TO_DISPLAY, $all_status[Stamps::TO_DISPLAY], 'info'],
                    [Stamps::REVOKED, $all_status[Stamps::REVOKED], 'warning'],
                    [Stamps::DELETED, $all_status[Stamps::DELETED], 'danger'],
                ],
            ],
            [
                'attribute' => 'product_id',
                'value' => function(LogsStatus $model){
                    return !empty($model->product_id) ? @$model->product_->name : '';
                },
                'headerOptions' => ['style'=>'width:150px']
            ],
//            'phone',
//            'device_id',
//            'lat_lng',
//            'user_id',
            [
                'attribute' => 'updated_by',
                'value' => function(LogsStatus $model){
                    return @$model->user_->full_name ? @$model->user_->full_name : @$model->user_->username ;
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function(LogsStatus $model){
                    return $model->created_at ? date('H:i | d/m/Y',$model->created_at) : '';
                },
                'headerOptions' => ['style'=>'width:130px']
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
