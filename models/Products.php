<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_description
 * @property string $description
 * @property string $image
 * @property string $gtin
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 */
class Products extends \yii\db\ActiveRecord
{
    const PRODUCT_INACTIVE = 0;
    const PRODUCT_ACTIVE = 1;
    const PRODUCT_DELETED = -1;
    const PRODUCT_HIDDEN = -2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['short_description', 'description', 'image'], 'string'],
            [['user_id', 'status', 'created_at', 'created_by'], 'integer'],
            [['name', 'gtin'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên sản phẩm',
            'short_description' => 'Mô tả ngắn',
            'description' => 'Mô tả',
            'image' => 'Hình ảnh',
            'gtin' => 'Mã gtin',
            'user_id' => 'Doanh nghiệp',
            'status' => 'Trạng thái',
            'created_at' => 'Thời gian tạo',
            'created_by' => 'Người tạo',
        ];
    }
    public static function getStatus(){
        return [
            self::PRODUCT_INACTIVE => 'Chờ duyệt',
            self::PRODUCT_ACTIVE => 'Kích hoạt',
            self::PRODUCT_DELETED => 'Đã xóa',
            self::PRODUCT_HIDDEN => 'Đã ẩn',
        ];
    }

    public function getUser_(){ // get Business
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getUser__(){ // get user
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
