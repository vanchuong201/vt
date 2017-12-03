<?php
/**
 * Created by PhpStorm.
 * User: vanchuong201
 * Date: 11/30/2017
 * Time: 11:00 AM
 */
namespace app\api\controllers;

use yii\rest\Controller;
use Yii;
use yii\web\Response;

class SmsController extends Controller {
    public function actionIndex(){
        $request = Yii::$app->request;

        $phone = $request->get('userid');
        $mess = $request->get('content','');
        $mess = explode(' ',urldecode($mess));
        $code = $mess[0]; // nhỡ thằng ngu nào nó lại nhắn linh tinh thì lấy đoạn text đầu coi là code


















        $json = [
            'status' => 0,
            'message'=>'xxxxxxxx',
        ];
        return $json;
    }
}