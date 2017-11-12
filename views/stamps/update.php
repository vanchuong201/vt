<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stamps */

$this->title = 'Update Stamps: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stamps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stamps-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
