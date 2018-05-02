<?php

namespace app\controllers;

use yii\web\Controller;

class SernoOutputController extends base\SernoOutputController
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionReport()
    {
        return $this->render('report');
    }
}