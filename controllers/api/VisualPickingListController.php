<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "VisualPickingListController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class VisualPickingListController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\VisualPickingList';
}
