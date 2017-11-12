<?php

namespace app\controllers;

use app\helpers\CodeHelper;
use app\models\Stamps;
use Yii;
use yii\web\Response;

class ScanController extends \yii\web\Controller
{
    public function actionIndex(){
        $request = Yii::$app->request;
        $code = $request->get('code',null);
        $error = false;
        $message = [];
        $isQrm = false;

        if(empty($code)){ // empty code
            $error = true;
            $message = ['class'=>'danger', 'content'=>' Không xác định được mã tem, vui lòng quét lại ! #100 '];
        }
        else{ //
            $encode = CodeHelper::endCodeStamp($code); // [type_code, id, user_id]

            Stamps::$user_id = $encode['user_id'];

            if( !$encode['user_id'] || !Stamps::tableName() ){
                $error = true;
                $message = ['class'=>'danger', 'content'=>' Không xác định được mã tem, vui lòng quét lại ! #101 '];
            }else{
                $stamp = Stamps::findOne($encode['id']);
                if(empty($stamp)){
                    $error = true;
                    $message = ['class'=>'danger', 'content'=>' Không xác định được mã tem, vui lòng quét lại ! #102 '];
                }else{
                    // Lấy thông tin sản phẩm
                    $product = [];

                    // Check Stamp
                    if($stamp->status == Stamps::TO_DISPLAY){ // Tem trưng bày
                        $message = ['class'=>'info', 'content'=>'Đây là sản phẩm trưng bày'];
                    }
                    elseif ($stamp->status == Stamps::ACTIVE_FOR_RELEASE){ // Tem đang ở trạng thái kích hoạt đem đi dán
                        if( $encode['type_code'] == 3 || $encode['type_code'] == 4 ){ //QRM
                            $isQrm = true;
                        }elseif ( $encode['type_code'] == 1 || $encode['type_code'] == 2 ){ // code_id
                            // HOLDING ......
                        }else{
                            $error = true;
                            $message = ['class'=>'danger', 'content'=>' Không xác định được mã tem, vui lòng quét lại ! #103 '];
                        }


                    }
                    elseif ( $stamp->status == Stamps::SOLD_OUT ){
                        $message = ['class'=>'warning', 'content'=>' Sản phẩm đã được <strong>xác thực</strong> trước đây bởi người dùng. (Đã bán) '];
                    }
                    else{
                        $error = true;
                        $message = ['class'=>'danger', 'content'=>' Không xác định được mã tem, vui lòng quét lại ! #104 '];
                    }
                }
            }
        }



        return $this->renderPartial('scan',[
            'error' => $error,
            'message' => $message,
            'isQrm' => $isQrm,
        ]);

    }

    public function actionConfirmCode(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $return = false;
        if($request->isAjax){
            $code = $request->bodyParams['code'];
            $code_sms = trim($request->bodyParams['hide_code']);
            if(!empty($code)){
                $encode = CodeHelper::endCodeStamp($code); // [type_code, id, user_id]
                Stamps::$user_id = $encode['user_id'];
                $stamp = Stamps::findOne($encode['id']);
                if($stamp && $stamp->code_sms === $code_sms){
                    // Thực hiện cập nhật trạng thái cho tem:
                    $stamp->status = Stamps::SOLD_OUT;
                    if($stamp->save()){
                        $return = true;
                    }else{
                        $return = false;
                    }
                }else{
                    $return = false;
                }
            }else{
                $return = false;
            }
        }

        return $return;
    }



}
