<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtDang */

$this->title = 'Update Vt Dang: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Vt Dangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vt-dang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
