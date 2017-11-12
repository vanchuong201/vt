<?php

use app\models\Stamps;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StampsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $all_status */
/* @var $all_service */

$this->title = 'Danh sách tem';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stamps-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'visible' => Yii::$app->user->isAdminGroup,
            ],
            [
                'attribute' => 'serial',
                'value' => function(Stamps $model){
                    return $model->serial;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'code_id',
                'visible' => Yii::$app->user->isAdminGroup,
            ],
            [
                'attribute' => 'qrm',
                'visible' => Yii::$app->user->isAdminGroup,
            ],
            [
                'attribute' => 'code_sms',
                'visible' => Yii::$app->user->isAdminGroup,
            ],
            [
                'attribute' => 'stamp_service',
                'value' => function(Stamps $model) use ($all_service) {
                    return !empty($all_service[$model->stamp_service]) ? $all_service[$model->stamp_service] : $model->stamp_service ;
                }
            ],
            [
                'attribute' => 'product_id',
                'value' => function(Stamps $model){
                    return !empty($model->product_id) ? @$model->product_->name : '';
                },
                'headerOptions' => ['style'=>'width:150px']
            ],

//            'name',
            [
                'attribute' => 'order_id',
                'value' => function(Stamps $model){
                    return !empty($model->order_id) ? @$model->order_->name : '';
                },
                'headerOptions' => ['style'=>'width:120px']
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
//            'user_scan',
//            'device_id',
            [
                'attribute' => 'phone',
                'headerOptions' => ['style'=>'width:120px']
            ],
//            'country',
//            'city',
//            'geo_location',
//            'ip',
//            'district',
//            'to_city',
//            'to_district',
//            'to_address',
            [
                'attribute' => 'active_time',
                'label' => 'Th/gian xác thực',
                'value' => function(Stamps $model){
                    return $model->active_time ? date('H:i | d/m/Y') : '';
                },
                'headerOptions' => ['style'=>'width:130px']
            ],
//            'own_product',
//            'sim_manage',
//            [
//                'attribute' => 'expire_time',
//                'value' => function(Stamps $model){
//                    return $model->created_time ? date('H:i | d/m/Y') : '';
//                }
//            ],
            [
                'attribute' => 'created_time',
                'value' => function(Stamps $model){
                    return $model->created_time ? date('H:i | d/m/Y') : '';
                },
                'headerOptions' => ['style'=>'width:150px']
            ],
//            'counter',
//            'current_counter',

//            [
//                'class' => 'yii\grid\ActionColumn',
//                'contentOptions' => ['style'=>'width:70px']
//            ],
        ],
    ]); ?>
</div>
