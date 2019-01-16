<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "CutiTblController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class CutiTblController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\CutiTbl';
}
