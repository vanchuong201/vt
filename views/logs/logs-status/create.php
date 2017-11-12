<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\logs\LogsStatus */

$this->title = 'Create Logs Status';
$this->params['breadcrumbs'][] = ['label' => 'Logs Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
