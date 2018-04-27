<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "JobOrderController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class JobOrderController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\JobOrder';
}
