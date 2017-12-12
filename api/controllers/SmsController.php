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
use app\models\User;

class SmsController extends Controller {
    public function actionIndex(){
        $request = Yii::$app->request;
        $message = ''; $status = 0;

        $phone = trim($request->get('phone',null));
        $code = trim($request->get('code',null));

        if(empty($code)){ // empty code
            $message = 'Khong xac dinh duoc ma tem !';
        }
        else{ //
            $encode = CodeHelper::endCodeStamp($code); // [type_code, id, user_id]
            Stamps::$user_id = $encode['user_id'];

            if( !$encode['user_id'] || !Stamps::tableName() ){ // Không có bảng tem này
                $message = 'Ma tem khong ton tai!';
            }else{
                $stamp = Stamps::findOne($encode['id']);
                if(empty($stamp)){ // không có tem này
                    $message = 'Ma tem khong ton tai !';
                }else{
                    // Check Stamp
                    if($stamp->status == Stamps::TO_DISPLAY){ // Tem trưng bày
                        $message = 'Day la san pham trung bay!';
                    }
                    elseif ($stamp->status == Stamps::ACTIVE_FOR_RELEASE){ // Tem đang ở trạng thái kích hoạt đem đi dán
                        if($encode['type_code'] == 1 || $encode['type_code'] == 2){
                            if($stamp->phone == $phone){
                                $message = 'Ban da xac thuc san pham nay truoc do roi!';
                            }else{
                                $short_name_company = User::findOne($encode['user_id'])->short_name;
                                $status = 1;
                                $message = "San pham chinh hang duocj phan phoi boi cong ty $short_name_company ";
                                $stamp->status = Stamps::SOLD_OUT;
                                $stamp->phone = $phone;
                                $stamp->save(false);
                            }
                        }else{
                            $message = 'Ma tem khong hop le!';
                        }

                    }
                    elseif ( $stamp->status == Stamps::SOLD_OUT ){
                        $message = 'San pham da duoc xac thuc boi so dien thoai khac!';
                    }
                    else{
                        $message = 'Ma tem loi!';
                    }
                }
            }
        }

        echo json_encode([
            'status'=>$status,
            'message' => $message,
            ]);
        die;
    }
}