<?php
namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\GojekOrderTbl;
use yii\web\Controller;

class GoMachineOrderInformationController extends Controller
{
    public function actionIndex()
    {
    	$model = GojekOrderTbl::find()
    	->where([
    		'source' => 'MCH',
    		'STAT' => 'O'
    	])
    	->orderBy('GOJEK_DESC')
    	->all();

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'model' => $model,
		]);
    }
}