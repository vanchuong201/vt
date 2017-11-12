<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\logs\LogsCg */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Logs Cgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-cg-view">

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
            'code',
            'status_before',
            'status_confirm',
            'code_type',
            'parcel_id',
            'service',
            'product_id',
            'phone',
            'device_id',
            'lat_lng',
            'user_id',
            'updated_by',
            'created_at',
        ],
    ]) ?>

</div>
