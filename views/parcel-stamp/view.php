<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ParcelStamp;

/* @var $this yii\web\View */
/* @var $model app\models\ParcelStamp */
/* @var $all_status */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách lô tem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-stamp-view">


    <p>
        <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Xóa', ['delete', 'id' => $model->id], [
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
                'attribute'=>'id',
                'visible'=>Yii::$app->user->isAdminGroup
            ],
            'name',
            [
                'attribute'=>'user_id',
                'value'=>function(ParcelStamp $model){
                    return !empty($model->user_->full_name) ? $model->user_->full_name : $model->user_->username;
                },
                'visible'=>Yii::$app->user->isAdminGroup
            ],
            'quantity',
            [
                'attribute' => 'service',
                'value' => function(ParcelStamp $model) use ($all_service) {
                    return !empty($all_service[$model->service]) ? $all_service[$model->service] : $model->service ;
                }
            ],
            'expiry_time',
            [
                'attribute'=>'status',
                'value'=> function(ParcelStamp $model) use ($all_status){
                    return $all_status[$model->status];
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function(ParcelStamp $model){
                    return date('H:i', $model->created_at).'&nbsp;&nbsp;'.date('d/m/Y', $model->created_at);
                }
            ],
            [
                'attribute' => 'created_by',
                'value' => function(ParcelStamp $model){
                    return $model->user__->full_name ? $model->user__->full_name : $model->user__->username;
                },
            ],
//            'status_zip_excel',
            'link_excel',
        ],
    ]) ?>

</div>
