<?php

namespace app\modules\vo_thuat\models;

use Yii;

/**
 * This is the model class for table "z_person".
 *
 * @property integer $id
 * @property string $id_card
 * @property string $full_name
 * @property string $birthday
 * @property string $cmnd
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property integer $don_vi
 * @property integer $chuc_vu
 * @property integer $mon_vo
 * @property integer $dang
 * @property integer $dang_cap
 * @property integer $dai
 * @property integer $cap
 * @property string $description
 */
class VtPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'z_person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_card', 'full_name', 'dang_cap'], 'required'],
            [['don_vi', 'chuc_vu', 'mon_vo', 'dang', 'dang_cap', 'dai', 'cap'], 'integer'],
            [['description'], 'string'],
            [['id_card', 'full_name', 'birthday', 'cmnd', 'email', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_card' => 'Id Card',
            'full_name' => 'Họ và tên',
            'birthday' => 'Ngày sinh',
            'cmnd' => 'Chứng minh thư',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'address' => 'Địa chỉ',
            'don_vi' => 'Don Vi',
            'chuc_vu' => 'Chuc Vu',
            'mon_vo' => 'Mon Vo',
            'dang' => 'Dang',
            'dang_cap' => 'Dang Cap',
            'dai' => 'Dai',
            'cap' => 'Cap',
            'description' => 'Description',
        ];
    }
}
