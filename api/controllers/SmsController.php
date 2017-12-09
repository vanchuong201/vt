<?php
/**
 * Created by PhpStorm.
 * User: vanchuong201
 * Date: 11/30/2017
 * Time: 11:00 AM
 */
namespace app\api\controllers;

use app\helpers\CodeHelper;
use app\models\Stamps;
use yii\rest\Controller;
use Yii;

class SmsController extends Controller {
    public function actionIndex(){
        $request = Yii::$app->request;

        $phone = trim($request->get('phone',null));
        $code = trim($request->get('code',null));

        if(empty($code)){ // empty code
            $message = 'Không xác định được mã tem !';
        }
        else{ //
            $encode = CodeHelper::endCodeStamp($code); // [type_code, id, user_id]
            Stamps::$user_id = $encode['user_id'];

            if( !$encode['user_id'] || !Stamps::tableName() ){ // Không có bảng tem này
                $message = 'Mã tem không tồn tại!';
            }else{
                $stamp = Stamps::findOne($encode['id']);
                if(empty($stamp)){ // không có tem này
                    $message = 'Mã tem không tồn tại !';
                }else{
                    // Check Stamp
                    if($stamp->status == Stamps::TO_DISPLAY){ // Tem trưng bày
                        $message = 'Đây là sản phẩm trưng bày!';
                    }
                    elseif ($stamp->status == Stamps::ACTIVE_FOR_RELEASE){ // Tem đang ở trạng thái kích hoạt đem đi dán
                        if($encode['type_code'] == 1 || $encode['type_code'] == 2){
                            if($stamp->phone == $phone){
                                $message = 'Bạn đã xác thực sản phẩm này trước đó rồi!';
                            }else{
                                $message = 'Bạn đã xác thực thành công sản phẩm này!';
                            }
                        }else{
                            $message = 'Mã tem không hợp lệ!';
                        }

                    }
                    elseif ( $stamp->status == Stamps::SOLD_OUT ){
                        $message = 'Sản phẩm đã được xác thực!';
                    }
                    else{
                        $message = 'Mã tem lỗi!';
                    }
                }
            }
        }

        echo json_encode([
            'message' => $message,
            ]);
        die;
    }
}