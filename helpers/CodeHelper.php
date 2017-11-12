<?php

namespace app\helpers;
use app\models\Products;
use app\models\User;
use Yii;
use yii\helpers\VarDumper;

class CodeHelper
{

    static function endCodeSerial($code) {
        $code = trim($code);
        $code = str_replace("_","-",$code);
        $code = str_replace(" ","-",$code);
        $arr = explode("-",$code);
        if (count($arr)<2) { // truong hop la serial dac biet config trong bang user va trong bang item

            $sprefix = "";
            $i = 0;
            for ( ;$i < strlen($code); $i++){
                $onechar = $code[$i];
                if (!is_numeric($onechar)) {
                    $sprefix .= $onechar;
                }else
                    break;
            }
            if($i < strlen($code)){

                $arCode['id']  = (int)substr( $code, $i );

                $sqlProduct = "select user_id from products where serial_prefix =upper('".$sprefix."') limit 1 ";//.$arItem['item_id'];
                $re = Products::findBySql( $sqlProduct )->one();
                //$arProduct = $re->user_id;

                if( !empty($re->user_id) ) {
                    $arCode['user_id'] = $re->user_id;//substr( $code, 0, strlen($code)-7);
                    $arCode['type_code'] = 0;
                    //print_r($arCode);
                    return $arCode;
                }
            }
            $arNumber = str_split( Yii::$app->params['code_char'] );
            $code = self::encode( $code, $arNumber, 26 );
            $arCode['id']  = (int)substr( $code, strlen($code)-7 );
            $arCode['user_id'] = substr( $code, 0, strlen($code)-7);
            $arCode['type_code']  = 0;
            //print_r($arCode);
            return $arCode;
        }

        $arNumber = str_split( Yii::$app->params['code_char'] );
        $arCode['user_id'] =  self::encode( $arr[0], $arNumber, 26 );
        $arCode['id'] = (int)$arr[1];
        $arCode['type_code']  = 0;
        return $arCode;
    }

    static function endCodeStamp($code) {
//        echo $code."<br>";
//        $arcode = explode('.', $code);
//        // $arcode[1] => chỉ số cho biết độ dài của id tem
//        if( !empty($arcode) && count($arcode)>1 ) {
//            $code = $arcode[0];
//            $code = base_convert( $code, 36, 10 );
//            $arCode['type_code']  = (int)substr( $code, strlen($code)-2 );
//            $arCode['id']       = (int)substr( $code, strlen($code)-($arcode[1]+2), $arcode[1] );
//            $code = substr( $code, 0, strlen($code)-($arcode[1]+2) );
//        } else {
//            $code = base_convert( $code, 36, 10 );
//            $arCode['type_code']  = (int)substr( $code, strlen($code)-2 );
//            $code = (int)substr( $code, 0, strlen($code)-2 );
//            if( strlen($code) < 8 ) {
//                $arCode['id']       = (int)substr( $code, 0, strlen($code) );
//                $code = substr( $code, 0, strlen($code)-6);
//            } elseif(strlen($code) > 8) {
//                $arCode['id']       = (int)substr( $code, strlen($code)-7, 7 );
//                $code = substr( $code, 0, strlen($code)-7);
//            } else {
//                $arCode['id']       = (int)substr( $code, strlen($code)-6, 6 );
//                $code = substr( $code, 0, strlen($code)-6);
//            }
//        }
        $len_id = (int)substr( $code, strlen($code)-1 );
        $code = substr( $code, 0, strlen($code)-1 );
        $code = base_convert( $code, 36, 10 );
        $arCode['type_code']  = (int)substr( $code, strlen($code)-2 );  //01,02: code id; 03,04: qrm: Đéo hiểu, tìm hiểu sau
        $arCode['id']       = (int)substr( $code, (strlen($code)-($len_id+2)), $len_id );
        $code = substr( $code, 0, strlen($code)-($len_id+2) );
//        echo $arCode['id'];
//        $arNumber = str_split( Yii::$app->params['code_char'] );
//        if( $arCode['type_code'] == 1 || $arCode['type_code'] == 2 ) {
//            $arCode['user_id'] = base_convert($code, 36, 10);
//        } else {
//            $arCode['user_id'] = base_convert( $code, 32, 10 );
//        }
        $arCode['user_id'] = $code;
        /*
        if( $arCode['type_code'] == 1 ) {
            $arCode['user_id']        = base_convert( $code, 36, 10 );
//            $arCode['user_id']        = $this->encode( $code, $arNumber, 26 );
        } elseif( $arCode['type_code'] == 3) {
            $arCode['user_id']        = base_convert( $code, 36, 10 );
//            $arCode['user_id']      = $this->encode( $code, $arNumber, 10 );
        } elseif( $arCode['type_code'] == 2) {
//            $arCode['business_code']        = base_convert( $code, 32, 10 );
            $arCode['business_code']  = $this->encode( $code, $arNumber, 22 );
        } elseif( $arCode['type_code'] == 4) {
//            $arCode['business_code']        = base_convert( $code, 32, 10 );
            $arCode['business_code'] = $this->encode( $code, $arNumber, 22 );
        }
        if( $arCode['type_code'] == 2 || $arCode['type_code'] == 4) {
            $user = new User();
            $arUser = $user->getUserByBusinessCode( $arCode['business_code'] );
            if( !empty($arUser) ) {
                $arCode['user_id'] = $arUser['id'];
            }
        }
        */

        return $arCode;
    }

    static function endCodeSms($code) {
        $arNumber = str_split( Yii::$app->params['code_char'] );
        $code = self::encode( $code, $arNumber, 24 );
        $arCode['id']  = (int)substr( $code, strlen($code)-7 );
        $arCode['user_id'] = substr( $code, 0, strlen($code)-7);
        return $arCode;
    }

    //giải mã
    static function encode ( $number, $arNumber, $hex = 36 ) {
        $arNum= str_split($number);
        $nn = count($arNum);
        $num = 0;
        foreach( $arNum as $n ) {
            $nn--;
            $so = array_search( $n, $arNumber );
            $so = $so ? $so : 0;
            $num += $so * pow($hex, $nn);
        }
        return $num;
    }
}