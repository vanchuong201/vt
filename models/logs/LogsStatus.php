<?php

namespace app\models\logs;

use Yii;

/**
 * This is the model class for table "logs_status".
 *
 * @property integer $id
 * @property string $code_start
 * @property string $code_end
 * @property integer $parcel_id
 * @property integer $service
 * @property integer $status_old
 * @property integer $status_new
 * @property integer $product_id
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
            [['id', 'parcel_id', 'service', 'status_old', 'status_new', 'product_id', 'user_id', 'updated_by'], 'integer'],
            [['code_start', 'code_end', 'created_at'], 'string', 'max' => 128],
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
            'parcel_id' => 'Parcel ID',
            'service' => 'Service',
            'status_old' => 'Status Old',
            'status_new' => 'Status New',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
        ];
    }
}
