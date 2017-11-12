<?php
/* @var $this yii\web\View */
/* @var $message */
/* @var $error */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Title</title>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        #product-namex
    </style>
</head>
<body>
<div class="container-fluid">

<?php if($error): ?>
    <!--  ERROR STAMP  -->
    <div class="row" id="product-name" style="margin-top: 30px;">
        <div class="col-md-12">
            <div class="alert alert-<?=$message['class']?> text-center">
                <strong><?=$message['content']?></strong>
            </div>
        </div>
    </div>
    <!--  ERROR STAMP end -->
<?php else: ?>

    <!--  IS STAMP INFO  -->

    <!--Product image-->
    <div class="row" id="product-image" >
        <div class="col-md-4 col-sm-4 col-xs-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
            <img src="/css/images/ex/2.jpg" width="100%">
        </div>
    </div>
    <!--Product name-->
    <div class="row" id="product-name">
        <div class="col-md-12 text-center">
            <h2><strong>Sản phẩm Abc Xyz</strong></h2>
        </div>
    </div>

    <!--Message-->
    <?php if(!empty($message)){ ?>
    <div class="row" id="code-message">
        <div class="col-md-12">
            <div class="alert alert-<?=@$message['class']?> text-center">
                <strong><?=@$message['content']?></strong>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="col-md-12" id="confirm-block">
        <div class="input-group">
            <input id="code-hide" type="text" class="form-control">
            <span class="input-group-btn">
                <button id="confirm-sb" type="button" class="btn btn-info">Xác thực</button>
            </span>
        </div>
        <small id="confirm-hint" style="display:block; color: #777; padding-top: 3px;">Hãy cào và nhập mã để <strong>xác thực</strong> bạn đã mua sản phẩm này</small>
    </div>

    <hr>

    <div class="row" id="product-detail">
        <div class="col-md-12">
            <h3 class="text-center">THÔNG TIN SẢN PHẨM</h3>
            <strong>Công dụng:</strong>
            <p> - Giúp an thần kinh</p>
            <p> - Hỗ trợ liệu pháp điều trị rối loạn giấc ngủ ở trẻ nhỏ</p>
            <strong>Đối tượng sử dụng:</strong>
            <p> - Trẻ bị rối lọan giấc ngủ</p>
            <p> - Trẻ hay giật mình, quấy khóc</p>
            <p> - Trẻ bị lo âu, mất ngủ</p>
            <strong>Chứng chỉ & chứng nhận</strong>
            <p> 23917/2015/ATTP-XNCB</p>
        </div>

        <div class="col-md-12">
            <h3 class="text-center">Thông tin doanh nghiệp</h3>
            <div class="row">
                <p class="col-md-3 col-sm-3 col-xs-3"><strong>Công ty</strong></p>
                <p class="col-md-9 col-sm-9 col-xs-9">Coca Cola</p>
            </div>
            <div class="row">
                <p class="col-md-3 col-sm-3 col-xs-3"><strong>Địa chỉ</strong></p>
                <p class="col-md-9 col-sm-9 col-xs-9">Hoàng Hoa Thám, Tây Hồ, Hà Nội</p>
            </div>
            <div class="row">
                <p class="col-md-3 col-sm-3 col-xs-3"><strong>SĐT</strong></p>
                <p class="col-md-9 col-sm-9 col-xs-9">1900 1001</p>
            </div>
            <div class="row">
                <p class="col-md-3 col-sm-3 col-xs-3"><strong>Email</strong></p>
                <p class="col-md-9 col-sm-9 col-xs-9">CocaCola@gmail.com</p>
            </div>
            <div class="row">
                <p class="col-md-3 col-sm-3 col-xs-3"><strong>Website</strong></p>
                <p class="col-md-9 col-sm-9 col-xs-9">coca-cola.com</p>
            </div>
        </div>
    </div>
    <hr>
    <!--  IS STAMP INFO end -->
<?php endif; ?>
</div>
</body>
</html>

<script>
    $( document ).ready(function() {
        $('#confirm-sb').on('click',function() {
            alert('aaaaaa');
            var code_confirm = $('code-hide').val();
            if(! code_confirm.trim()){
                $('#confirm-hint').text('abc');
            }else {

            }
        })
    });

</script>

<?php
//$js = <<<JS
//$('#confirm-sb').on('click',function() {
//  alert('aaaaaa');
//  var code_confirm = $('code-hide').val();
//  if(! code_confirm.trim()){
//      $('#confirm-hint').text('abc');
//  }else {
//
//  }
//})
//function confirmStamp() {
//
//}
//JS;
//$this->registerJs($js);
