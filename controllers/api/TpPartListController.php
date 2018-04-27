<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "TpPartListController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class TpPartListController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\TpPartList';
}
