<?php

namespace app\controllers;
use app\models\search\JobOrderSearch;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

/**
* This is the class for controller "JobOrderController".
*/
class JobOrderController extends \app\controllers\base\JobOrderController
{

    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
    public function actionIndex()
    {
        $searchModel  = new JobOrderSearch;
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
