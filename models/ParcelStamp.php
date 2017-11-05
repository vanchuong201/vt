<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parcel_stamp".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $quantity
 * @property integer $service
 * @property string $expiry_time
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status_zip_excel
 * @property string $link_excel
 */
class ParcelStamp extends \yii\db\ActiveRecord
{
    const REQUEST = 0;
    const ACCEPTED = 2;
    const GEN_SUCCESS = 1;
    const BLOCKED = 3;

    const GENERATING = -2;
    const HOLDING = -4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parcel_stamp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_by'], 'required'],
            [['user_id', 'quantity', 'service', 'status', 'created_at', 'created_by', 'status_zip_excel'], 'integer'],
            [['name', 'link_excel'], 'string', 'max' => 255],
            [['expiry_time'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên lô tem',
            'user_id' => 'Doanh nghiệp',
            'quantity' => 'Số lượng tem',
            'service' => 'Dịch vụ tem',
            'expiry_time' => 'Số ngày bảo hành',
            'status' => 'Trạng thái',
            'created_at' => 'Thời gian tạo',
            'created_by' => 'Người tạo',
            'status_zip_excel' => 'Yêu cầu tạo excel',
            'link_excel' => 'Link tải excel',
        ];
    }

    public static function getStatus(){
        return [
            self::REQUEST => 'Yêu cầu',
            self::ACCEPTED => 'Đã duyệt',
            self::GEN_SUCCESS => 'Đã tạo tem',
            self::BLOCKED => 'Đã khóa',
            self::GENERATING => 'Đang tạo tem',
            self::HOLDING => 'Đang chờ tạo tem',
        ];
    }



    public function getUser_(){ // get Business
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getUser__(){ // get user
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
