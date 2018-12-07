<?php

namespace app\controllers;

use yii\web\Controller;

class ManufactureFlowController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		return $this->render('index');
	}
}