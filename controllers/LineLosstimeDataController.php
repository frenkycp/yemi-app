<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\LineLosstimeDataSearch;

/**
* This is the class for controller "LineLosstimeDataController".
*/
class LineLosstimeDataController extends \app\controllers\base\LineLosstimeDataController
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
        $searchModel = new LineLosstimeDataSearch;
        $searchModel->proddate = date('Y-m-d');
        
        if (\Yii::$app->request->get('proddate') !== null) {
			$searchModel->proddate = \Yii::$app->request->get('proddate');
		}

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
