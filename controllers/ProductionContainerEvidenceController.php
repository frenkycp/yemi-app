<?php

namespace app\controllers;

/**
* This is the class for controller "ProductionContainerEvidenceController".
*/
class ProductionContainerEvidenceController extends \app\controllers\base\ProductionContainerEvidenceController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
}
