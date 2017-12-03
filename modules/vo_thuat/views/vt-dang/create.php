<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtDang */

$this->title = 'Create Vt Dang';
$this->params['breadcrumbs'][] = ['label' => 'Vt Dangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vt-dang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
