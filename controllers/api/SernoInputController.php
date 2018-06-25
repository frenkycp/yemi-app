<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "SernoInputController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SernoInputController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\SernoInput';
}
