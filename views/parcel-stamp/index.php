<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\ParcelStamp;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchs\ParcelStampSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
//            'user_id',
            'quantity',
            'service',
            // 'expiry_time',
             'status',
             [
                 'attribute' => 'created_at',
                 'format' => 'raw',
                 'value' => function(ParcelStamp $model){
                     return date('H:i:i', $model->created_at).'<br>'.date('d-m-Y', $model->created_at);
                 }
             ],
            // 'created_by',
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
