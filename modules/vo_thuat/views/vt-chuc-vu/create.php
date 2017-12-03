<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtChucVu */

$this->title = 'Create Vt Chuc Vu';
$this->params['breadcrumbs'][] = ['label' => 'Vt Chuc Vus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vt-chuc-vu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
