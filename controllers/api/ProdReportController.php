<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "ProdReportController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ProdReportController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\ProdReport';
}
