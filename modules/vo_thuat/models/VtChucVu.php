<?php

namespace app\modules\vo_thuat\models;

use Yii;

/**
 * This is the model class for table "z_chuc_vu".
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 */
class VtChucVu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'z_chuc_vu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
        ];
    }
}
