<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "ProdPlanDataController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ProdPlanDataController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\WipEffTbl';
}
