<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtChucVu */

$this->title = 'Update Vt Chuc Vu: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Vt Chuc Vus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vt-chuc-vu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
