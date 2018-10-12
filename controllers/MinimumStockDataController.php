<?php

namespace app\controllers;

/**
* This is the class for controller "MinimumStockDataController".
*/
class MinimumStockDataController extends \app\controllers\base\MinimumStockDataController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
}
