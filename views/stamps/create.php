<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Stamps */

$this->title = 'Create Stamps';
$this->params['breadcrumbs'][] = ['label' => 'Stamps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stamps-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
