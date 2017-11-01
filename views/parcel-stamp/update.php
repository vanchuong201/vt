<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ParcelStamp */

$this->title = 'Update Parcel Stamp: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Parcel Stamps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parcel-stamp-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
