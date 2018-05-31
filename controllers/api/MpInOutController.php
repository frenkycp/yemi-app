<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "MpInOutController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class MpInOutController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\MpInOut';
}
