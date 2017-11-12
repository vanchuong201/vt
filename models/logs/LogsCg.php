<?php

namespace app\models\logs;

use app\models\ParcelStamp;
use app\models\Products;
use app\models\Stamps;
use app\models\User;
use Yii;

/**
 * This is the model class for table "logs_cg".
 *
 * @property integer $id
 * @property string $code
 * @property integer $status_before
 * @property integer $status_confirm
 * @property integer $code_type
 * @property integer $parcel_id
 * @property integer $service
 * @property integer $product_id
 * @property string $phone
 * @property string $device_id
 * @property string $lat_lng
 * @property integer $user_id
 * @property integer $updated_by
 * @property string $created_at
 */
class LogsCg extends \yii\db\ActiveRecord
{
    const CONFIRM_SUCCESS = 1;
    const CONFIRM_FAILED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs_cg';
    }

    public static function  getStatusConfirm(){
        return [
            self::CONFIRM_SUCCESS => 'Xác thực đúng',
            self::CONFIRM_FAILED => 'Xác thực sai',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_before', 'status_confirm', 'code_type', 'parcel_id', 'service', 'product_id', 'user_id', 'updated_by'], 'integer'],
            [['code', 'phone', 'device_id', 'lat_lng', 'created_at'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'status_before' => 'Status Before',
            'status_confirm' => 'Trạng thái xác thực',
            'code_type' => 'Loại code',
            'parcel_id' => 'Lô tem',
            'service' => 'Dịch vụ',
            'product_id' => 'Sản phẩm',
            'phone' => 'Số điện thoại',
            'device_id' => 'Thiết bị',
            'lat_lng' => 'Vị trí',
            'user_id' => 'Doanh nghiệp',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
        ];
    }

    public function getSerial(){
        Stamps::$user_id = User::getBusinessId();
        return $this->hasOne(Stamps::className(), ['id' => 'code']);
    }
    public function getProduct_(){
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
    public function getParcel_(){
        return $this->hasOne(ParcelStamp::className(), ['id' => 'parcel_id']);
    }


    public static function writeLogs($data){
        $re = Yii::$app->db->createCommand()->insert(self::tableName(),$data)->execute();
    }
}
