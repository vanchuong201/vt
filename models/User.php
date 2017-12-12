<?php
/**
 * Created by PhpStorm.
 * User: vanchuong201
 * Date: 10/30/2017
 * Time: 12:23 AM
 */

namespace app\models;
use webvimark\modules\UserManagement\UserManagementModule;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $type
 * @property integer $business_id
 * @property string $full_name
 * @property string $short_name
 */

class User extends \webvimark\modules\UserManagement\models\User
{
    const USER_NORMAL = 0;
    const USER_BUSINESS = 1;
    const USER_MOD = 2;
    const USER_ADMIN = 3;


    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'unique'],
            ['username', 'trim'],

            [['status', 'email_confirmed', 'business_id', 'type'], 'integer'],
            [['full_name'], 'string', 'max' => 255],

            ['email', 'email'],
            ['email', 'validateEmailConfirmedUnique'],

            ['bind_to_ip', 'validateBindToIp'],
            ['bind_to_ip', 'trim'],
            ['bind_to_ip', 'string', 'max' => 255],

            ['password', 'required', 'on'=>['newUser', 'changePassword']],
            ['password', 'string', 'max' => 255, 'on'=>['newUser', 'changePassword']],
            ['password', 'trim', 'on'=>['newUser', 'changePassword']],
            ['password', 'match', 'pattern' => Yii::$app->getModule('user-management')->passwordRegexp],

            ['repeat_password', 'required', 'on'=>['newUser', 'changePassword']],
            ['repeat_password', 'compare', 'compareAttribute'=>'password'],
        ];
    }


    public static function getTypeList()
    {
        return array(
            self::USER_NORMAL => 'Nhân viên',
            self::USER_BUSINESS => 'Doanh nghiệp',
            self::USER_MOD      => 'Moderator',
            self::USER_ADMIN    => 'Admin',
        );
    }

    public static function getBusinessId($id=false){
        $user = $id ? User::findOne($id) : Yii::$app->user->identity;
        $business_id = @$user->type == self::USER_BUSINESS ? @$user->id : @$user->business_id;
        return $business_id;
    }

    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'username'           => UserManagementModule::t('back', 'Login'),
            'superadmin'         => UserManagementModule::t('back', 'Superadmin'),
            'confirmation_token' => UserManagementModule::t('back', 'Confirmation Token'),
            'registration_ip'    => UserManagementModule::t('back', 'Registration IP'),
            'bind_to_ip'         => UserManagementModule::t('back', 'Bind to IP'),
            'status'             => UserManagementModule::t('back', 'Status'),
            'gridRoleSearch'     => UserManagementModule::t('back', 'Roles'),
            'created_at'         => UserManagementModule::t('back', 'Created'),
            'updated_at'         => UserManagementModule::t('back', 'Updated'),
            'password'           => UserManagementModule::t('back', 'Password'),
            'repeat_password'    => UserManagementModule::t('back', 'Repeat password'),
            'email_confirmed'    => UserManagementModule::t('back', 'E-mail confirmed'),
            'email'              => UserManagementModule::t('back', 'E-mail'),
            'type'               => UserManagementModule::t('back', 'Kiểu thành viên'),
            'business_id'        => UserManagementModule::t('back', 'Mã doanh nghiệp'),
            'full_name'          => UserManagementModule::t('back', 'Name'),
        ];
    }
}