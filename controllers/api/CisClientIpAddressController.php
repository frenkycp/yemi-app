<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "CisClientIpAddressController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class CisClientIpAddressController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\CisClientIpAddress';
}
