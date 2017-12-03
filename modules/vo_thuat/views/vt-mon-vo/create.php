<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtMonVo */

$this->title = 'Create Vt Mon Vo';
$this->params['breadcrumbs'][] = ['label' => 'Vt Mon Vos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vt-mon-vo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
