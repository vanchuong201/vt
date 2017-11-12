<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\logs\LogsCg */

$this->title = 'Create Logs Cg';
$this->params['breadcrumbs'][] = ['label' => 'Logs Cgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-cg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
