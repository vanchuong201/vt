<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            'status_old',
            'status_new',
            'product_id',
            'user_id',
            'updated_by',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
