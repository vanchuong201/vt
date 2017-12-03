<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtPerson */

$this->title = 'Update Vt Person: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vt People', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vt-person-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
