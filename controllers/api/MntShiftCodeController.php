<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "MntShiftCodeController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class MntShiftCodeController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\MntShiftCode';
}
