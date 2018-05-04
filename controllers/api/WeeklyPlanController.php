<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "WeeklyPlanController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class WeeklyPlanController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\WeeklyPlan';
}
