<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtLevel */

$this->title = 'Create Vt Level';
$this->params['breadcrumbs'][] = ['label' => 'Vt Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vt-level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>