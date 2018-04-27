<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoOutputView;

class SernoOutputController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function actionReport()
    {
        return $this->render('report');
    }
}