<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\logs\search\LogsStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
            'code_start',
            'code_end',
            'parcel_id',
            'service',
            'status',
            'product_id',
//            'phone',
//            'device_id',
//            'lat_lng',
//            'user_id',
            'updated_by',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
