<?php
/**
 * Created by PhpStorm.
 * User: vanchuong201
 * Date: 10/27/2017
 * Time: 3:11 AM
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class UserController extends \webvimark\modules\UserManagement\controllers\UserController
{
    public function actionIndex()
    {
        return parent::actionIndex(); // TODO: Change the autogenerated stub
    }

    public function actionCreate()
    {
        return parent::actionCreate(); // TODO: Change the autogenerated stub
    }
}