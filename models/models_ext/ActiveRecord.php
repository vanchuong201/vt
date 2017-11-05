<?php
/**
 * Created by PhpStorm.
 * User: vanchuong201
 * Date: 11/5/2017
 * Time: 10:34 AM
 */
namespace app\models\models_ext;

use app\models\User;
use Yii;

class ActiveRecordCustomize extends \yii\db\ActiveRecord
{
    /*
     * find with user_id =  user_id of current business
     * @param string
     *      -ex: 'user_id', 'business_id'
     */
    public static function find_u($u='user_id')
    {
        return parent::find()->where([$u=>User::getBusinessId()]);
            // return parent::find()->where(['<>', 'id', 1]);
    }
}