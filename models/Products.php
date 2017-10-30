<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property integer $vid
 * @property string $gtin
 * @property string $gln
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 */
class Products extends \yii\db\ActiveRecord
{
    const PRODUCT_INACTIVE = 0;
    const PRODUCT_ACTIVE = 1;

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
            [['vid', 'user_id', 'status', 'created_at', 'created_by'], 'integer'],
            [['name', 'gtin', 'gln'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'vid' => 'Vid',
            'gtin' => 'Gtin',
            'gln' => 'Gln',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
