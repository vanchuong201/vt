<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Stamps */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stamps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stamps-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'code_id',
            'serial',
            'qrm',
            'code_sms',
            'otp',
            'product_id',
            'parcel_id',
            'status',
            'device_id',
            'phone',
            'geo_location',
            'city',
            'district',
            'address',
            'ip',
            'to_city',
            'to_district',
            'to_address',
            'active_time:datetime',
            'own_product',
            'sim_manage',
            'expire_time:datetime',
            'created_time:datetime',
            'stamp_service',
            'counter',
            'current_counter',
        ],
    ]) ?>

</div>
