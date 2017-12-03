<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\vo_thuat\models\search\VtPersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách thành viên';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vt-person-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Thêm thành viên', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_card',
            'full_name',
            'birthday',
            [
                'attribute'=>'cmnd',
                'headerOptions' => ['style'=>'width:350px'],
                'contentOptions' => ['style'=>'width:350px'],
            ],
            'phone',
            'email:email',
            'address',
            'don_vi',
            'chuc_vu',
            'mon_vo',
            'dang',
            'dang_cap',
            'dai',
            'cap',
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
