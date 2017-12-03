<?php

namespace app\controllers;

use app\helpers\CodeHelper;
use app\models\logs\LogsCg;
use app\models\logs\LogsStatus;
use app\models\Stamps;
use Yii;
use yii\helpers\Url;
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
                    $product = []; // AAAAAAAAAAAAAA chưa làm

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


    public function actionSms(){
        $request = Yii::$app->request;
        $sms = $request->get('sms');
        $code = 'abc123';

        $mess = ''; // trả về sms cho user

        $encode = CodeHelper::endCodeSms($sms);
        if( !$encode['user_id'] || !Stamps::tableName() ){
            $mess = 'Mã tem giả';
        }else{
            $stamp = Stamps::findOne($encode['id']);
            if(empty($stamp)){
                $mess = 'Mã tem giả'; //Không xác định được mã tem, vui lòng quét lại
            }else{
                // Lấy thông tin sản phẩm
                $product = []; // AAAAAAAAAAAAAA chưa làm

                // Check Stamp
                if($stamp->status == Stamps::TO_DISPLAY){ // Tem trưng bày
                    $mess = 'trung bay'; // Đây là sản phẩm trưng bày
                }
                elseif ( $stamp->status == Stamps::SOLD_OUT ){
                    $mess = 'da ban'; // san pham da ban
                }
                else{
                    $mess = ' true'; // chox ngayf hoiw ngu :D
                }
            }
        }
        return $mess;
    }




    // Xác nhận nhập mã xác thực
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
                if($stamp && $stamp->code_id === $code_sms){ // mã xác thực đúng
                    // Thực hiện cập nhật trạng thái cho tem:
                    $stamp->status = Stamps::SOLD_OUT;
                    $stamp->active_time = time();
                    LogsStatus::writeLogs([
                        'status'=>Stamps::SOLD_OUT, 'code_start'=>$stamp->id,
                        'service'=>$stamp->stamp_service, 'parcel_id'=>$stamp->parcel_id,
                        'product_id'=>$stamp->product_id, 'user_id'=>$encode['user_id'],
                        'created_at'=>time()
                    ]);
                    LogsCg::writeLogs([
                        'code'=>$stamp->id, 'status_confirm'=>LogsCg::CONFIRM_SUCCESS,
                        'code_type'=>$encode['type_code'], 'parcel_id'=>$stamp->parcel_id,
                        'service'=>$stamp->stamp_service, 'product_id'=>$stamp->product_id,
                        'user_id'=>$encode['user_id'], 'created_at'=>time()
                    ]);
                    if($stamp->save()){
                        $return = true;
                    }else{
                        $return = false;
                    }
                }else{ // Mã xác thực sai
                    LogsCg::writeLogs([
                        'code'=>$stamp->id, 'status_confirm'=>LogsCg::CONFIRM_FAILED,
                        'code_type'=>$encode['type_code'], 'parcel_id'=>$stamp->parcel_id,
                        'service'=>$stamp->stamp_service, 'product_id'=>$stamp->product_id,
                        'user_id'=>$encode['user_id'], 'created_at'=>time()
                    ]);
                    $return = false;
                }
            }else{ // Ko bắt được code
                $return = false;
            }
            return $return;
        }

        return $this->redirect(Url::home());
    }



}
