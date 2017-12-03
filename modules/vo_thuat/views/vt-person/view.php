<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\vo_thuat\models\VtPerson */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vt People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vt-person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_card',
            'full_name',
            'birthday',
            'cmnd',
            'phone',
            'email:email',
            'address',
            'don_vi',
            'chuc_vu',
            'mon_vo',
            'dang',
            'dang_cap',
            'dai',
            'cap',
            'description:ntext',
        ],
    ]) ?>

</div>
