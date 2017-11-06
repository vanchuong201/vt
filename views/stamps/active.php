<?php
/**
 * Created by PhpStorm.
 * User: vanchuong201
 * Date: 11/6/2017
 * Time: 1:27 AM
 */

use yii\widgets\ActiveForm;
use app\models\Stamps;

/* @var $this yii\web\View */
/* @var $all_parcel */

$this->title = 'Kích hoạt tem';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="active-stamps-index">
    <?php
    $form = ActiveForm::begin([
        'id' => 'stamp-active-form',
    ]) ?>

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="radio">
                <label><input type="radio" name="type_active" value="<?=Stamps::ACTIVE_BY_PARCEL?>">Kích hoạt lô tem</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="type_active" value="<?=Stamps::ACTIVE_BY_BATCH?>">Kích hoạt dãy tem</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="type_active" value="<?=Stamps::ACTIVE_BY_LIST?>">Kích hoạt dánh sách tem</label>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="x_content" id="select-parcel-block">
                <label for="active-parcel">Chon lô tem: :</label>
                <select name="parcel" id="active-parcel" class="form-control">
                    <option value="0">Chọn lô tem...</option>
                    <?php foreach ($all_parcel as $k=>$parcel): ?>
                        <option value="<?=$parcel['id']?>"><?=$parcel['name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="x_content">
                <label for="">Nhập serial đầu cuối :</label>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <input name="start" type="text" class="form-control has-feedback-left" placeholder="Serial đầu">
                        <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <input name="end" type="text" class="form-control has-feedback-left" placeholder="Serial cuối">
                        <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>
            </div>

            <div class="x_content">
                <label for="active-list-serial">Nhập danh sách serial :</label>
                <input type="text" id="active-list-serial" class="form-control" name="list">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Nhập lại</button>
                    <button type="submit" class="btn btn-success">Kích hoạt</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end()
    ?>

</div>