<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\ParcelStamp;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ParcelStampSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $all_service */
/* @var $all_status */

$this->title = 'Quản lý lô tem';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-stamp-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tạo mới', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            [
//                'attribute' => 'id',
//                'filter' => false
//            ],
            'name',
            [
                'attribute' => 'user_id',
                'value' => function(ParcelStamp $model){
                    return $model->user_->full_name;
                },
                'visible' => Yii::$app->user->isAdminGroup
            ],
            'quantity',
            [
                'attribute' => 'service',
                'value' => function(ParcelStamp $model) use ($all_service) {
                    return !empty($all_service[$model->service]) ? $all_service[$model->service] : $model->service ;
                }
            ],
            // 'expiry_time',
            [
                'class'=>'webvimark\components\StatusColumn',
                'attribute'=>'status',
                'optionsArray'=>[
                    [ParcelStamp::REQUEST, $all_status[ParcelStamp::REQUEST], 'warning'],
                    [ParcelStamp::ACCEPTED, $all_status[ParcelStamp::ACCEPTED], 'success'],
                    [ParcelStamp::GEN_SUCCESS, $all_status[ParcelStamp::GEN_SUCCESS], 'primary'],
                    [ParcelStamp::BLOCKED, $all_status[ParcelStamp::BLOCKED], 'danger'],
                    [ParcelStamp::GENERATING, $all_status[ParcelStamp::GENERATING], 'info'],
                    [ParcelStamp::HOLDING, $all_status[ParcelStamp::HOLDING], 'default'],
                ],
            ],
             [
                 'attribute' => 'created_at',
                 'format' => 'raw',
                 'value' => function(ParcelStamp $model){
                     return date('H:i', $model->created_at).'<br>'.date('d/m/Y', $model->created_at);
                 }
             ],
            [
                'attribute' => 'created_by',
                'value' => function(ParcelStamp $model){
                    return $model->user__->full_name ? $model->user__->full_name : $model->user__->username;
                },
            ],
            // 'status_zip_excel',
            // 'link_excel',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => \app\models\User::canRoute('delete')
                ]
            ],
        ],
    ]); ?>
</div>
