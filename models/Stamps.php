<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "items_2".
 *
 * @property integer $id
 * @property string $code_id
 * @property string $serial
 * @property string $qrm
 * @property string $code_sms
 * @property integer $product_id
 * @property string $name
 * @property integer $order_id
 * @property string $type
 * @property integer $status
 * @property string $user_scan
 * @property string $device_id
 * @property string $phone
 * @property string $country
 * @property string $city
 * @property string $geo_location
 * @property string $ip
 * @property string $district
 * @property string $to_city
 * @property string $to_district
 * @property string $to_address
 * @property integer $active_time
 * @property integer $own_product
 * @property string $sim_manage
 * @property integer $expire_time
 * @property integer $created_time
 * @property integer $stamp_service
 * @property integer $counter
 * @property integer $current_counter
 */
class Stamps extends \yii\db\ActiveRecord
{
    const INACTIVE = 0;
    const ACTIVE_FOR_RELEASE = 1;
    const SOLD_OUT = 2; // Trạng thái này được kích hoạt khi quét phủ cào : code_id hoặc nhắn sms
    const TO_DISPLAY = 3; // Sản phẩm trưng bày
    const REVOKED = 4; // Thu hồi
    const DELETED = 5; // HỦY

    const ACTIVE_BY_PARCEL = 'parcel';
    const ACTIVE_BY_BATCH = 'batch';
    const ACTIVE_BY_LIST = 'list';

    public static function getStatus(){
        return [
            self::INACTIVE => 'Chưa kích hoạt',
            self::ACTIVE_FOR_RELEASE => 'Đã kích hoạt',
            self::SOLD_OUT => 'Đã xác thực',
            self::TO_DISPLAY => 'Trưng bày',
            self::REVOKED => 'Thu hồi',
            self::DELETED => 'Đã hủy',
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'order_id', 'status', 'active_time', 'own_product', 'expire_time', 'created_time', 'stamp_service', 'counter', 'current_counter'], 'integer'],
            [['code_id', 'serial', 'qrm', 'code_sms', 'name', 'user_scan', 'device_id', 'phone', 'country', 'city', 'geo_location', 'ip', 'district', 'to_city', 'to_district', 'to_address', 'sim_manage'], 'string', 'max' => 128],
            [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_id' => 'Code ID',
            'serial' => 'Serial',
            'qrm' => 'Qrm',
            'code_sms' => 'Code Sms',
            'product_id' => 'Sản phẩm',
            'name' => 'Name',
            'order_id' => 'Lô',
            'type' => 'Type',
            'status' => 'Trạng thái',
            'user_scan' => 'Người quets',
            'device_id' => 'Thiết bị quét',
            'phone' => 'Số điện thoại',
            'country' => 'Quốc gia',
            'city' => 'Thành phố',
            'district' => 'Quận huyện',
            'geo_location' => 'Vị trí',
            'ip' => 'Ip',

            'to_city' => 'Thành phố phân phối',
            'to_district' => 'To District',
            'to_address' => 'To Address',

            'active_time' => 'Thời gian xác thực',
            'own_product' => 'Own Product',
            'sim_manage' => 'Sim Manage',
            'expire_time' => 'Expire Time',

            'created_time' => 'Thời gian tạo',
            'stamp_service' => 'Dịch vụ',

            'counter' => 'Counter',
            'current_counter' => 'Current Counter',
        ];
    }


    public function getProduct_(){
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
    public function getOrder_(){
        return $this->hasOne(ParcelStamp::className(), ['id' => 'order_id']);
    }


    public static function activeStamps($type,$con){
        if($type==self::ACTIVE_BY_PARCEL){
            if(!empty($count = self::updateAll(['status'=>self::ACTIVE_FOR_RELEASE], ['order_id'=>$con, 'status'=>[self::INACTIVE,self::REVOKED]]))){
                Yii::$app->getSession()->setFlash('success', 'Kích hoạt thành công! Số lượng: '.$count);
            }else{
                Yii::$app->getSession()->setFlash('warning', 'Kích hoạt chưa thành công, vui lòng thử lại !');
            }
        }

        elseif ($type==self::ACTIVE_BY_BATCH){
            $condition = ['and',['>=', 'id', $con[0]],['<=', 'id', $con[1]], ['status'=>[self::INACTIVE,self::REVOKED]] ];
            if(!empty($count = self::updateAll(['status'=>self::ACTIVE_FOR_RELEASE], $condition))){
                Yii::$app->getSession()->setFlash('success', 'Kích hoạt thành công! Số lượng: '.$count);
            }else{
                Yii::$app->getSession()->setFlash('warning', 'Kích hoạt chưa thành công, vui lòng thử lại !');
            }
        }

        elseif ($type==self::ACTIVE_BY_LIST){
            $condition = ['id'=>$con];
            if(!empty($count = self::updateAll(['status'=>self::ACTIVE_FOR_RELEASE], $condition))){
                Yii::$app->getSession()->setFlash('success', 'Kích hoạt thành công! Số lượng: '.$count);
            }else{
                Yii::$app->getSession()->setFlash('warning', 'Kích hoạt chưa thành công, vui lòng thử lại !');
            }
        }
    }
}
