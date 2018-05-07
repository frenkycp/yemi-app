<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "ShipCustomerController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ShipCustomerController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\ShipCustomer';
}
