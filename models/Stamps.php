<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "items_[user_id]".
 *
 * @property integer $id
 * @property string $code_id
 * @property string $serial
 * @property string $qrm
 * @property string $code_sms
 * @property string $otp
 * @property integer $product_id
 * @property integer $parcel_id
 * @property integer $status
 * @property string $device_id
 * @property string $phone
 * @property string $geo_location
 * @property string $city
 * @property string $district
 * @property string $address
 * @property string $ip
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
    static $tbl_prefix = 'items_';
    static $user_id = null;


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
        $table = self::$tbl_prefix.self::$user_id;
        $tableSchema = Yii::$app->db->schema->getTableSchema($table);
        if($tableSchema){
            return $table;
        }else{
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'parcel_id', 'status', 'active_time', 'own_product', 'expire_time', 'created_time', 'stamp_service', 'counter', 'current_counter'], 'integer'],
            [['code_id', 'serial', 'qrm', 'code_sms', 'otp', 'device_id', 'phone', 'geo_location', 'city', 'district', 'address', 'ip', 'to_city', 'to_district', 'to_address', 'sim_manage'], 'string', 'max' => 128],
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
            'otp' => 'Otp',
            'product_id' => 'Sản phẩm',
            'parcel_id' => 'Lô',
            'status' => 'Trạng thái',
            'device_id' => 'Thiết bị quét',
            'phone' => 'Số điện thoại',
            'geo_location' => 'Vị trí',
            'city' => 'Thành phố',
            'district' => 'Quận huyện',
            'address' => 'Địa chỉ',
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
    public function getParcel_(){
        return $this->hasOne(ParcelStamp::className(), ['id' => 'parcel_id']);
    }


//    public static function activeStamps($type,$con){
//        if($type===self::ACTIVE_BY_PARCEL){ // active lô
//            $condition = ['parcel_id'=>$con];
//            $count = self::updateAll(['status'=>self::ACTIVE_FOR_RELEASE], $condition);
//        }
//
//        elseif ($type===self::ACTIVE_BY_BATCH){ // active dãy
//            $condition = ['and',['>=', 'id', $con[0]],['<=', 'id', $con[1]], ];
//            $count = self::updateAll(['status'=>self::ACTIVE_FOR_RELEASE], $condition);
//        }
//
//        elseif ($type===self::ACTIVE_BY_LIST){ // active list
//            $condition = ['id'=>$con];
//            $count = self::updateAll(['status'=>self::ACTIVE_FOR_RELEASE], $condition);
//        }
//        else{
//            $count = false;
//        }
//
//        return $count;
//    }
    public static function activeStamps($value,$condition){
        $count = self::updateAll($value, $condition);
        return $count;
    }
}
