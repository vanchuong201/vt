<?php
// */2 * * * * php var/www/html/evs/tools/gencode.php
// */2 * * * * php var/www/html/evs/tools/genexcel.php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
ini_set('set max_allowed_packet', 1024);
ini_set('memory_limit', '-1');
set_time_limit(0); // cấp phát thêm bộ nhớ cho hàm

date_default_timezone_set('Asia/Ho_Chi_Minh');
$curprg = basename(__FILE__);
include_once('config.php');
include_once('LogEvent.php');
include_once('Strings.php');
include_once('mysql.php');

$type_item = [
    'STAMP_ACTIVE_FAKE' => ['id' => 1, 'title' => 'Tem chống giả', 'alias' => 'CG', 'domain' => 'https://cg.icheck.com.vn/'],
    'STAMP_GUARANTEE' => ['id' => 2, 'title' => 'Tem bảo hành', 'alias' => 'BH', 'domain' => 'https://bh.icheck.com.vn/'],
    'STAMP_EVS' => ['id' => 3, 'title' => 'Tem chống tràn hàng', 'alias' => 'TH', 'domain' => 'https://th.icheck.com.vn/'],
    'STAMP_FIXED' => ['id' => 4, 'title' => 'Tem cố định', 'alias' => 'CD', 'domain' => 'https://cd.icheck.com.vn/'],
];
$arype = array(
    1 => 'STAMP_ACTIVE_FAKE',
    2 => 'STAMP_GUARANTEE',
    3 => 'STAMP_EVS',
    4 => 'STAMP_FIXED',
);

define('TIME_NOW', time());
$off = 0;
$len = 10000;
$type_excel = 1; //1: xuất all thành nhiều file theo $len

$mysql = Mysql::getInstance();
//lấy tiến trình cần xử lý
$sql = "select * from request_excel where status=0";
$re = $mysql->setQuery($sql);
$arProcess = $mysql->getOneRow($re);
//print_r($arProcess);

if (!empty($arProcess)) {
    $item_order_id = $arProcess["items_order_id"];
    $sql = "update request_excel set `status`=-2 where items_order_id=" . $item_order_id; // chan khong cho cung order chay //
    $mysql->setQuery($sql);

    $table_items = "items_" . $arProcess["user_id"];

    $sql = "select max(id) as maxid from " . $table_items . " where order_id=" . $item_order_id;
    $re = $mysql->setQuery($sql);
    $maxid = (int)$mysql->getOneRow($re)["maxid"];
    $sql = "select min(id) as minid from " . $table_items . " where order_id=" . $item_order_id;
    $re = $mysql->setQuery($sql);
    $minid = (int)$mysql->getOneRow($re)["minid"];
//    echo $minid.'-'.$maxid.'-'.$arProcess["quantity"];die;
    $inBlock = 1;
    while ($minid <= $maxid) {
        $sql = "select id,code_id,UPPER(serial) sserial,qrm,UPPER(code_sms) scode_sms,`stamp_service` from " . $table_items . " where order_id=" . $item_order_id." and id>=" .$minid . " order by id  limit 0," . $arProcess["quantity"];
        $re = $mysql->setQuery($sql);
        $allrow = $mysql->getRow($re);
       // $minid += count($allrow);

        $ds = "/";
        $file_url = dirname(__DIR__) . $ds . 'backend/web/assets/excel' . $ds . "ICHECK_CODE_LO_" . $item_order_id . $ds;
        if (!file_exists($file_url)) {
            @mkdir($file_url);
        }
        $file_url = $file_url . "block_" . $inBlock . ".csv";
        //var_dump($file_url);die;
        $f = fopen($file_url, "wb");
        $start_serial = "";
        $end_serial = "";

        $title = "\"" . "ID" . "\",\"" . "SMS" . "\",\"" . "SERIAL" . "\",\"" . "QRM" . "\",\"" . "CODE_ID" . "\"\r\n";
        fwrite($f, $title);
        foreach ($allrow as $arow) {
            if ($start_serial == "") {
                $start_serial = $arow["sserial"];
            }
            $minid = (int)$arow["id"] + 1;
            $end_serial = $arow["sserial"];
            $str1 = "\"" . $arow["id"] . "\",\"" . $arow["scode_sms"] . "\",\"" . $arow["sserial"] . "\",\"" .
                setDomain($arow["stamp_service"]) . $arow["qrm"] . "\",\"" .
                setDomain($arow["stamp_service"]) . $arow["code_id"] . "\"\r\n";
            fwrite($f, $str1);
        }

        fwrite($f, "block_" . $inBlock . " - start:" . $start_serial . " - " . $end_serial . " \r\n");
        $inBlock++;
        fclose($f);
    }
    $file_url = dirname(__DIR__) . $ds . 'web/assets/excel' . $ds ;
    if (!file_exists($file_url)) {
        @mkdir($file_url);
    }
    zip($file_url,  "GTEL_CODE_LO_" . $item_order_id );

    deleteDir($file_url."GTEL_CODE_LO_" . $item_order_id);

    $link_download = 'assets/excel' . $ds . "GTEL_CODE_LO_" . $item_order_id . ".zip";

    $sql = "update items_order set `status_zip_excel`=1,`link_excel`='" . $link_download . "' where id=" . $item_order_id; //da sinh xong //
    $mysql->setQuery($sql);

    if( $mysql->setQuery($sql) ){
        $sql = "delete from request_excel where items_order_id=" . $item_order_id; //da sinh xong thì xóa cái request này đi //
        $mysql->setQuery($sql);
    }

    echo 'done';
    // Sau này nhớ ghi log vào đâu đó !!!!!!!


}else{
    return false;
}
/*
 * $type_item = [
    'STAMP_ACTIVE_FAKE'     => ['id'=>1, 'title'=>'Tem chống giả', 'alias'=>'CG', 'domain'=>'https://cg.icheck.com.vn/'],
    'STAMP_GUARANTEE'       => ['id'=>2, 'title'=>'Tem bảo hành', 'alias'=>'BH', 'domain'=>'https://bh.icheck.com.vn/'],
    'STAMP_EVS'             => ['id'=>3, 'title'=>'Tem chống tràn hàng', 'alias'=>'TH', 'domain'=>'https://th.icheck.com.vn/'],
    'STAMP_FIXED'           => ['id'=>4, 'title'=>'Tem cố định', 'alias'=>'CD', 'domain'=>'https://cd.icheck.com.vn/'],
];

luật domain như sau:
chống giả là cg.icheck.com.vn,
bảo hành là bh.icheck.com.vn.
tràn hàng là th.icheck.com.vn,
chống giả và bảo hành là cgbh.icheck.com.vn,
chống giả và tràn hàng là cg.ịcheck.com.vn,
bảo hành và tràn hàng là bh.icheck.com.vn,
chống giả-bảo hành-tràn hàng là cgbh.icheck.com.vn

1 => 'Chống giả',
2 => 'Bảo hành',
3 => 'Tràn hàng',
4 => 'Chống giả - Bảo hành',
5 => 'Chống giả - Tràn hàng',
6 => 'Bảo hành - Tràn hàng',
7 => 'Chống giả - Bảo hành - Tràn hàng',
 */
function setDomain($type)
{
    return 'http://tem.gtel.vn/s/';

    // Hiện tại check dịch vụ theo tem, ko lấy theo domain nên tạm thời cứ trỏ về domain chống giả.
//    switch ($type) {
//        case 1:
//            return 'https://cg.icheck.com.vn/';
//        case 2:
//            return "https://th.icheck.com.vn/";
//        case 3:
//            return "https://bh.icheck.com.vn/";
//        case 4:
//            return "https://cgbh.icheck.com.vn/";
//        case 5:
//            return "https://cgth.icheck.com.vn/";
//        case 6:
//            return "https://bhth.icheck.com.vn/";
//        case 7:
//            return "https://cgbh.icheck.com.vn/";
//        case 8:
//            return "https://cg.icheck.com.vn/";
//    }
//    return "notfound/";
}

function zip($path = '', $zip_name = '')
{
    if (!extension_loaded('zip')) {
        return false;
    }
//die("===" . $path);
    set_time_limit(0);
    $zip = new \ZipArchive;
    if (!is_file($path.$zip_name) && !is_file($path . $zip_name . '.zip')) {
        $arFileExcel = [];
        if ($zip->open($path . $zip_name . '.zip', \ZipArchive::CREATE) === TRUE) {
            foreach (new \DirectoryIterator($path.$zip_name) as $fileInfo) {
                $fileName = $fileInfo->getFilename();
                //echo($fileName);
                if (is_file($path.$zip_name.'/'. $fileName) ) {
                   // echo($fileName);
                    $zip->addFile($path.$zip_name.'/'  . $fileName, $fileName);
                    $arFileExcel[] = $path.$zip_name.'/' . $fileName;
                }
            }
        }
        $zip->close();
        //xóa các file excel
        if (!empty($arFileExcel)) {
            foreach ($arFileExcel as $f_excel) {
                @unlink($f_excel);
            }
        }
        return $path . $zip_name . '.zip';
    } else {
        return $path . $zip_name . '.zip';
    }
}

function deleteDir($dirPath)
{
    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

?>
