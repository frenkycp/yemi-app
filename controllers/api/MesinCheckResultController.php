<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "MesinCheckResultController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class MesinCheckResultController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\MesinCheckResult';
}
