<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtPerson */

$this->title = 'Create Vt Person';
$this->params['breadcrumbs'][] = ['label' => 'Vt People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vt-person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
