<?php
/**
 * Created by PhpStorm.
 * User: vanchuong201
 * Date: 11/6/2017
 * Time: 1:27 AM
 */

use yii\widgets\ActiveForm;
use app\models\Stamps;
use kartik\select2\Select2;
use app\models\Products;
use app\models\User;
use yii\helpers\ArrayHelper;

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
            <div class="x_content" id="select-parcel-block">
                <label for="select-active-parcel"><input checked id="select-active-parcel" type="radio" onchange="" name="type_active" value="<?=Stamps::ACTIVE_BY_PARCEL?>">Kích hoạt lô tem</label>
                <select name="parcel" id="active-parcel" class="form-control">
                    <option value="0">Chọn lô tem...</option>
                    <?php foreach ($all_parcel as $k=>$parcel): ?>
                        <option value="<?=$parcel['id']?>"><?=$parcel['name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="x_content">
                <label for="select-active-start-end"><input id="select-active-start-end" type="radio" name="type_active" value="<?=Stamps::ACTIVE_BY_BATCH?>">Kích hoạt dãy tem</label>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <input disabled name="start" id="code_start" type="text" class="form-control has-feedback-left" placeholder="Serial đầu">
                        <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <input disabled name="end" id="code_end" type="text" class="form-control has-feedback-left" placeholder="Serial cuối">
                        <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>
            </div>

<!--            <div class="x_content">-->
<!--                <label for="select-active-list"><input id="select-active-list" type="radio" name="type_active" value="--><?//=Stamps::ACTIVE_BY_LIST?><!--">Kích hoạt danh sách tem</label>-->
<!--                <input disabled type="text" id="active-list-serial" class="form-control" name="list">-->
<!--            </div>-->
        </div>

        <div class="col-md-6 col-xs-12">
            <div class="x_content">
                <label for="product_id">Chọn sản phẩm</label>
                <?php
                echo Select2::widget([
                    'id' => 'product_id',
                    'name' => 'product_id',
                    'data' => ArrayHelper::map(Products::find()->select(['id','name'])->where(['user_id'=>User::getBusinessId()])->all(),'id','name'),
                    'options' => ['placeholder' => 'Chọn sản phẩm ...'],
                ])
                ?>
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

<?php
$js=<<<JS
$('input[name=type_active]').on('change',function() {
  var type_active = this.value;
  console.log(type_active);
  if(type_active==='parcel'){
      $('#active-parcel').prop('disabled',false);
      $('#code_start').prop('disabled',true);
      $('#code_end').prop('disabled',true);
      $('#active-list-serial').prop('disabled',true);
  }else if (type_active==='batch'){
      $('#active-parcel').prop('disabled',true);
      $('#code_start').prop('disabled',false);
      $('#code_end').prop('disabled',false);
      $('#active-list-serial').prop('disabled',true);
  }else if (type_active==='list'){
      $('#active-parcel').prop('disabled',true);
      $('#code_start').prop('disabled',true);
      $('#code_end').prop('disabled',true);
      $('#active-list-serial').prop('disabled',false);
  }
})

$('button[type=submit]').on('click',function(e) {
  var product_id = $('#product_id').val();
  if(!product_id){
      alert('Vui lòng chọn sản phẩm!'); return false;
  }
  
  var type_active = $('input[name="type_active"]:checked').val();
  console.log(type_active);
  if(type_active === 'parcel' && !parseInt($('#active-parcel').val())>0){
      alert('Bạn chưa chọn lô tem!'); return false;
  }else if( type_active === 'batch' && (!$('#code_start').val() || !$('#code_end').val()) ){
      alert('Bạn chưa nhập đầy dủ tem đầu, tem cuối!'); return false;
  }else if( type_active === 'list' && !$('#active-list-serial').val() ){
      alert('Bạn chưa nhập danh sách tem!'); return false;
  }
  
})

JS;
$this->registerJs($js);

$css=<<<CSS
.active-stamps-index label {cursor: pointer;}
CSS;
$this->registerCss($css);
