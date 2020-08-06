<?php

namespace app\controllers;

/**
* This is the class for controller "ScanTemperatureController".
*/
class ScanTemperatureController extends \app\controllers\base\ScanTemperatureController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
}
