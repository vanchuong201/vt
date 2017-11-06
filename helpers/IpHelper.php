<?php
/**
 * Created by PhpStorm.
 * User: chuongnv
 * Date: 8/10/2017
 * Time: 11:32 AM
 */

namespace app\helpers;

use Yii;

class IpHelper{

    static function getLocationInfo( $ip ) {
        $url = "http://ipinfo.io/{$ip}/json";
        // Create a stream
        if ( !function_exists('curl_init') ) {
            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'timeout' => 60
                )
            );

            $context = stream_context_create($opts);
            $res = @file_get_contents($url, false, $context);
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            $res = curl_exec($ch);
            curl_close($ch);
        }
        return $res ? json_decode($res) : false;
    }
}