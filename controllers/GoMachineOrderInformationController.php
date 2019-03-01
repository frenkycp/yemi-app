<?php
namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\GojekOrderTbl;
use yii\web\Controller;

class GoMachineOrderInformationController extends Controller
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$model = GojekOrderTbl::find()
    	->where([
    		'source' => 'MCH',
    		'STAT' => 'O'
    	])
    	->orderBy('GOJEK_DESC, issued_date')
    	->all();

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'model' => $model,
		]);
    }
}