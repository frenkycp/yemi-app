<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "SplOvertimeBudgetController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SplOvertimeBudgetController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\SplOvertimeBudget';
}
