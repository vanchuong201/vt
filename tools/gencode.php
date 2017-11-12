<?php
$start_time = time();

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
ini_set('set max_allowed_packet', 1024);
ini_set('memory_limit', '-1');
set_time_limit(0); // cấp phát thêm bộ nhớ cho hàm

$curprg = basename(__FILE__);
include_once('config.php');
include_once('LogEvent.php');
include_once('Strings.php');
include_once('mysql.php');
$id = @$_GET['oid'] ;

$mysql = Mysql::getInstance();
//Trạng thái: 0: yêu cầu, 1: hoàn thành, -1 hủy, 2: duyệt; -2: la dang sinh tem do; -4 huy cac order cung user id
$sql = "select * from parcel_stamp where status=2";

$re = $mysql->setQuery( $sql );
$arItem = $mysql->getOneRow( $re );
//echo $sql;
//print_r($arItem); die;
if( !empty($arItem)  ) {
    $stamp_service = $arItem["service"];
    // update sang trang thai -2( dang sinh)
    $sql ="UPDATE parcel_stamp SET `status`=-2 where id=".$arItem["id"];
    $re = $mysql->setQuery( $sql );

    //update sang trang thai =-4 la tam nghi
    $sql ="UPDATE parcel_stamp SET `status`=-4 where status=2 and user_id=".$arItem["user_id"];
    $re = $mysql->setQuery( $sql );

    //
    $sqlTable = "select id, username, business_code,special_serial from user where id = ".$arItem['user_id'];
    $re = $mysql->setQuery( $sqlTable );
    $arUser = $mysql->getOneRow( $re );
    $table = 'items_'.$arUser['id'];

    //thông tin sp
//    $sqlProduct = "select id, sku, name, status,serial_prefix from products where id = ".$arItem['item_id'];
//    echo $sqlProduct;die;
//    $re = $mysql->setQuery( $sqlProduct );
//    $arProduct = $mysql->getOneRow( $re );

    $serial_prefix = "";
    if( !empty($arProduct) ) {
        $arProduct['name'] = addslashes(stripslashes($arProduct['name']));
        $arProduct['name'] = str_replace('%', '%%', $arProduct['name']);
        $serial_prefix = $arProduct["serial_prefix"];

    }

    //lấy thông tin bảng có chưa
    $sql_check_tb = "show tables like '".$table."';";
//    die('a');
    $re = $mysql->setQuery( $sql_check_tb );
    //die;
    $is_exits = $mysql->getOne( $re );
 //   var_dump($sql_check_tb); die;

    if( !$is_exits ) {
        $create_table = "CREATE TABLE `{$table}` (
            `id`  int(11) NOT NULL AUTO_INCREMENT ,
            `code_id`  varchar(128) NULL DEFAULT '' COMMENT 'ID tem' ,
            `serial`  varchar(128) NULL DEFAULT '' ,
            `qrm`  varchar(128) NULL DEFAULT '' ,
            `code_sms`  varchar(128) NULL DEFAULT '' ,
            `otp`  varchar(128) NULL DEFAULT '' ,
            `product_id`  int(11) NULL DEFAULT 0 COMMENT 'ID sản phẩm' ,
            `parcel_id`  int(11) NULL DEFAULT 0 COMMENT 'ID đơn hàng (lô tem)' ,
            `status`  tinyint(1) NULL DEFAULT 0 COMMENT '' ,
            `device_id` varchar(128) DEFAULT '' COMMENT 'Id thiết bị',
            `phone` varchar(128) DEFAULT '' COMMENT 'Số điện thoại kích hoạt',
            `geo_location`  varchar(128) NULL DEFAULT '' ,
            `city` varchar(128) DEFAULT '' COMMENT 'Thành phố active',
            `district` varchar(128) DEFAULT '' COMMENT 'Quận active',
            `address` varchar(128) DEFAULT '' COMMENT 'address active',
            `ip`  varchar(128) NULL DEFAULT '' ,
            `to_city` varchar(128) DEFAULT '' COMMENT 'city phan phoi sp',
            `to_district` varchar(128) DEFAULT '' COMMENT 'Quan huyen phan phoi san pham',
            `to_address` varchar(128) DEFAULT '' COMMENT 'dia chi phan phoi san pham',
            `active_time` int(11) DEFAULT '0' COMMENT 'thời gian lúc xác thực',
            `own_product` int(11) DEFAULT '0' COMMENT '= customer.id : Chủ sở hữu sản phẩm, mua sản phẩm, cái này dùng cho bảo hành',
            `sim_manage` VARCHAR (128) DEFAULT '0' COMMENT '= Số sim trên thiết bị',
            `expire_time`  int(11) NULL DEFAULT 0 COMMENT 'Thời gian hết hạn bảo hành',
            `created_time`  int(11) NULL DEFAULT 0 ,
            `stamp_service` int(11) NULL DEFAULT 1 COMMENT 'Loai dich vu cua tem: params[stamp_service]' ,
            `counter` int(11) NULL DEFAULT 1000 COMMENT 'tong so lan dem'  ,
            `current_counter` int(11) NULL DEFAULT 1 COMMENT 'dem so lan kich hoat' ,
            PRIMARY KEY (`id`),
            KEY `idx_stamp_service` (`id`,`stamp_service`) USING HASH
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        var_dump( $mysql->setQuery( $create_table ) );
    } else{

        $lo_id =$arItem["id"];
        // xoa du lieu co lien quan den lo
        $sql_check_tb = "delete from ".$table." WHERE `parcel_id`='".$arItem["id"]."';";
        $re = $mysql->setQuery( $sql_check_tb );

    }


    $sql_get_max = "SELECT MAX(id) AS id_start FROM ".$table.";";
    $re = $mysql->setQuery( $sql_get_max );
    $id_start = $mysql->getOneRow( $re );
    //var_dump($id_start["id_start"]);die;
    if (!empty($id_start) && count($id_start) > 0){
        $off =(int) $id_start["id_start"] + 1;
    }
    else{
        $off =1;
    }
    $len = $off  + $arItem['quantity'];
    //build sql
    $arVal = array();
    $created_time = time();
    $sql = "insert into $table (id, code_id, serial, qrm, `code_sms`, `product_id`, `parcel_id`, status, created_time, stamp_service) values";
    $i = 0;
    $ii = 0;


    $arNumberFull = str_split($code_char_alpha);
    $arNumber = str_split($code_char);
    $arNum = str_split($code_num);
    if (strlen("".$len) < 6)
        $serial_format = "%'.06d";
    else
        $serial_format = "%'.0".strlen("".$len)."d";
    //$date_time =
    $counter = 0;
    for( $i=$off; $i<$len; $i++) {
        // if ($ii < 100000) {
        $prefix = $arUser['business_code'] != '' ? 1 : 0;
        $type = sprintf("%'.04d", $arItem['type']);
        $business_code = $arUser['business_code'];


        //số nguyên giới hạn 9 ký tự


        $prefix_code_id = sprintf("%'.09d", $arUser['id']);
        $prefix_qrm = sprintf("%'.09d", $arUser['id']);

        //$serial     = convert( $arUser['id'] . sprintf("%'.07d", $i), $arNumber, 26 ); //sprintf("%'.08d", $i); //mã hõa chỉ dùng ký tự chữ thường
        if($arUser['special_serial'] == 1){
            $serial = $serial_prefix . sprintf($serial_format, $i);
        }else {
            $serial = convert($arUser['id'], $arNumber, 26) . "-" . sprintf($serial_format, $i);
        }


        $code_sms = convert($arUser['id'] . sprintf("%'.07d", $i), $arNumber, 24);

        //số cuối strlen($i) ấn định độ dài id => mã điều khiển
        // prefix cua qrcode id = 01 hoac 02
        $code_id = base_convert($prefix_code_id . $i . (!$prefix ? '01' : '02'), 10, 36) . strlen($i);
        // prefix cua qrm =03 hoac 04
        $qrm = base_convert($prefix_code_id . $i . (!$prefix ? '03' : '04'), 10, 36) . strlen($i);

        $status = 0;
        $arVal[] = "($i, '$code_id', '$serial', '$qrm', '$code_sms', '{$arItem['product_id']}', '{$arItem['id']}', $status, $created_time,{$stamp_service})";
        $ii++;
        if ($ii > 10000) {
            $sql .= join(',', $arVal);

            $mysql->setQuery($sql);
            $sql = "insert into $table (id, code_id, serial, qrm, `code_sms`, `product_id`, `parcel_id`, status, created_time, stamp_service) values";
            $arVal = [];
            $ii = 0;
        }
        //} else {
        //  break;
        //}
    }
// update order dang dung ve trang thai cho sinh tem (=2)
    $sql11 ="UPDATE parcel_stamp SET `status`=2 where status=-4 and user_id=".$arItem["user_id"];
    $re = $mysql->setQuery( $sql11 );


    if( !empty($arVal) ) {
        $sql .= join( ',', $arVal );

        $mysql->setQuery( $sql );
        //cập nhật lại số bắt đầu chạy jobs

    }
    $sqlUp = "update parcel_stamp set status=1  WHERE id=".$arItem['id'];
    $mysql->setQuery( $sqlUp );
}

$end_time = time();
echo "Done ".($end_time - $start_time);

function convert( $number, $arNumber, $hex = 36 ) {
    $num = $number%$hex;
    $num = (isset($arNumber[$num]) ? $arNumber[$num] : $num);
    $numdivision = floor($number/$hex);

    if( $numdivision>0 ) {
        return convert( $numdivision, $arNumber, $hex ) . $num;
    } else {
        return $num;
    }
}

?>