<?php

namespace app\controllers;
use app\models\search\ProdReportSearch;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

/**
* This is the class for controller "ProdReportController".
*/
class ProdReportController extends \app\controllers\base\ProdReportController
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
        $searchModel  = new ProdReportSearch;
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('index', [
        'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
