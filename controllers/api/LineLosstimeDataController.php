<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "LineLosstimeDataController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class LineLosstimeDataController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\SernoLosstime';
}
