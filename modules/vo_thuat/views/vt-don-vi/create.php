<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtDonVi */

$this->title = 'Create Vt Don Vi';
$this->params['breadcrumbs'][] = ['label' => 'Vt Don Vis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vt-don-vi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
