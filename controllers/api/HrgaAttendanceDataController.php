<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "HrgaAttendanceDataController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class HrgaAttendanceDataController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\AbsensiTbl';
}
