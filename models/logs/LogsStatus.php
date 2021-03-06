<?php

namespace app\models\logs;

use app\controllers\logs\LogsStatusController;
use app\models\ParcelStamp;
use app\models\Products;
use app\models\Stamps;
use app\models\User;
use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "logs_status".
 *
 * @property integer $id
 * @property string $code_start
 * @property string $code_end
 * @property integer $parcel_id
 * @property integer $service
 * @property integer $status
 * @property integer $product_id
 * @property string $phone
 * @property string $device_id
 * @property string $lat_lng
 * @property integer $user_id
 * @property integer $updated_by
 * @property string $created_at
 */
class LogsStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'parcel_id', 'service', 'status', 'product_id', 'user_id', 'updated_by'], 'integer'],
            [['code_start', 'code_end', 'phone', 'device_id', 'lat_lng', 'created_at'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_start' => 'Code Start',
            'code_end' => 'Code End',
            'parcel_id' => 'Lô tem',
            'service' => 'Dịch vụ',
            'status' => 'Trạng thái',
            'product_id' => 'Sản phẩm',
            'phone' => 'Sdt',
            'device_id' => 'Thiết bị',
            'lat_lng' => 'Vị trí',
            'user_id' => 'User ID',
            'updated_by' => 'Người cập nhật',
            'created_at' => 'Thời gian cập nhật',
        ];
    }

    public function getSerialStart(){
        Stamps::$user_id = User::getBusinessId();
        return $this->hasOne(Stamps::className(), ['id' => 'code_start']);
    }
    public function getSerialEnd(){
        Stamps::$user_id = User::getBusinessId();
        return $this->hasOne(Stamps::className(), ['id' => 'code_end']);
    }
    public function getProduct_(){
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
    public function getParcel_(){
        return $this->hasOne(ParcelStamp::className(), ['id' => 'parcel_id']);
    }
    public function getUser_(){
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }


    public static function writeLogs($data){
        $re = Yii::$app->db->createCommand()->insert(self::tableName(),$data)->execute();
    }
}
