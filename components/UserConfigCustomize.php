<?php
/**
 * Created by PhpStorm.
 * User: vanchuong201
 * Date: 10/30/2017
 * Time: 12:07 AM
 */

namespace app\components;

use app\models\User;
use Yii;

class UserConfigCustomize extends \webvimark\modules\UserManagement\components\UserConfig
{
    public $loginUrl = ['/u/auth/login'];

    public function getIsBusiness()
    {
        return @Yii::$app->user->identity->type == User::USER_BUSINESS;
    }


    public function getIsMod(){

    }

    public function getIsAdminGroup(){
        return self::getIsSuperadmin();
//        return Yii::$app->user->isSuperadmin;
    }


}