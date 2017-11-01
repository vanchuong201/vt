<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchs\ParcelStampSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parcel Stamps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-stamp-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Parcel Stamp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'user_id',
            'quantity',
            'service',
            // 'expiry_time',
            // 'status',
            // 'created_at',
            // 'created_by',
            // 'status_zip_excel',
            // 'link_excel',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
