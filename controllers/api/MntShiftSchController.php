<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "MntShiftSchController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class MntShiftSchController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\MntShiftSch';
}
