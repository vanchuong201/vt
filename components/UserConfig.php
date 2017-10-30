<?php
/**
 * Created by PhpStorm.
 * User: vanchuong201
 * Date: 10/30/2017
 * Time: 12:07 AM
 */

namespace common\components;

use app\models\User;

class UserConfig extends \webvimark\modules\UserManagement\components\UserConfig
{
    public function getIsBusiness()
    {
        return @Yii::$app->user->identity->type == User::USER_BUSINESS;
    }
}