<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "ItemUnitController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ItemUnitController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\ItemUnit';
}
