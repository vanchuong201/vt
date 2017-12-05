<?php
/* @var $this yii\web\View */
/* @var $message */
/* @var $error */
/* @var $isQrm */
/* @var $product app\models\Products */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Title</title>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <style type="text/css">
        #product-namex
    </style>
    <?= \yii\helpers\Html::csrfMetaTags() ?>
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
        <p></p>
        <div class="col-md-4 col-sm-4 col-xs-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
            <img src="/css/images/no-image-product.gif" width="100%">
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

    <?php if($isQrm): ?>
    <div class="row" id="confirm-block">
       <div class="col-md-12">
           <div class="input-group">
               <input id="code-hide" type="text" class="form-control">
               <span class="input-group-btn">
                <button id="confirm-sb" type="button" class="btn btn-info">Xác thực</button>
            </span>
           </div>
           <small id="confirm-hint" style="display:block; color: #777; padding-top: 3px;">Hãy cào và nhập mã để <strong>xác thực</strong> bạn đã mua sản phẩm này</small>
       </div>
    </div>
    <?php endif; ?>

    <hr>

    <div class="row" id="product-detail">
        <div class="col-md-12">
            <?=$product->description?>
        </div>

<!--        <div class="col-md-12">-->
<!--            <h3 class="text-center">THÔNG TIN SẢN PHẨM</h3>-->
<!--            <strong>Công dụng:</strong>-->
<!--            <p> - Giúp an thần kinh</p>-->
<!--            <p> - Hỗ trợ liệu pháp điều trị rối loạn giấc ngủ ở trẻ nhỏ</p>-->
<!--            <strong>Đối tượng sử dụng:</strong>-->
<!--            <p> - Trẻ bị rối lọan giấc ngủ</p>-->
<!--            <p> - Trẻ hay giật mình, quấy khóc</p>-->
<!--            <p> - Trẻ bị lo âu, mất ngủ</p>-->
<!--            <strong>Chứng chỉ & chứng nhận</strong>-->
<!--            <p> 23917/2015/ATTP-XNCB</p>-->
<!--        </div>-->
<!---->
<!--        <div class="col-md-12">-->
<!--            <h3 class="text-center">Thông tin doanh nghiệp</h3>-->
<!--            <div class="row">-->
<!--                <p class="col-md-3 col-sm-3 col-xs-3"><strong>Công ty</strong></p>-->
<!--                <p class="col-md-9 col-sm-9 col-xs-9">Coca Cola</p>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <p class="col-md-3 col-sm-3 col-xs-3"><strong>Địa chỉ</strong></p>-->
<!--                <p class="col-md-9 col-sm-9 col-xs-9">Hoàng Hoa Thám, Tây Hồ, Hà Nội</p>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <p class="col-md-3 col-sm-3 col-xs-3"><strong>SĐT</strong></p>-->
<!--                <p class="col-md-9 col-sm-9 col-xs-9">1900 1001</p>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <p class="col-md-3 col-sm-3 col-xs-3"><strong>Email</strong></p>-->
<!--                <p class="col-md-9 col-sm-9 col-xs-9">CocaCola@gmail.com</p>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <p class="col-md-3 col-sm-3 col-xs-3"><strong>Website</strong></p>-->
<!--                <p class="col-md-9 col-sm-9 col-xs-9">coca-cola.com</p>-->
<!--            </div>-->
<!--        </div>-->
    </div>
    <hr>
    <!--  IS STAMP INFO end -->
<?php endif; ?>
</div>
</body>
</html>

<?php if($isQrm): ?>
<script>
    $( document ).ready(function() {
        $('#code-hide').focus(function () {
            $('#confirm-hint').css('color','#777').html('Hãy cào và nhập mã để <strong>xác thực</strong> bạn đã mua sản phẩm này');
        });

        $('#confirm-sb').on('click',function () {
            var code_confirm = $('#code-hide').val();
            if(! $.trim(code_confirm)){
                $('#confirm-hint').css('color','#e91e63').text('Hãy nhập mã code dưới lớp phủ cào trên con tem!');
            }else {
                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    url: '/scan/confirm-code',
                    type: 'POST',
                    data: {'hide_code': code_confirm,code:'<?=Yii::$app->request->get('code')?>' ,_csrf : csrfToken},
                    dataType: "json",
                    success: function(res) {
                        if(res === true){
                            $('#confirm-block').html('<div class="col-md-12"><div class="alert alert-success text-center"><strong>Xác thực sản phẩm thành công</strong></div></div>');
                        }else {
                            $('#code-hide').focus();
                            $('#code-hide:focus').css('border-color','#e91e63');
                            $('#confirm-hint').css('color','#e91e63').text('Thao tác không thành công, vui lòng thử lại !');
                        }
                    }
                });
            }
        })
    });

</script>
<?php endif; ?>