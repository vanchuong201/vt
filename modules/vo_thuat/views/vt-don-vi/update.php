<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtDonVi */

$this->title = 'Update Vt Don Vi: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Vt Don Vis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vt-don-vi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
