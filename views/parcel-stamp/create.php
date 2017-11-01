<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ParcelStamp */

$this->title = 'Create Parcel Stamp';
$this->params['breadcrumbs'][] = ['label' => 'Parcel Stamps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-stamp-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
