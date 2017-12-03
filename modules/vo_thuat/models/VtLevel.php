<?php

namespace app\modules\vo_thuat\models;

use Yii;

/**
 * This is the model class for table "z_level".
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property integer $type
 */
class VtLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'z_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status', 'type'], 'integer'],
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
            'type' => 'Type',
        ];
    }
}
