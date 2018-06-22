<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "ProductionInspectionController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ProductionInspectionController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\SernoInput';
}
