<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "SernoOutputController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SernoOutputController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\SernoOutput';
}
