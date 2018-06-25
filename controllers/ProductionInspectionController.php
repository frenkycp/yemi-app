<?php

namespace app\controllers;

use app\models\search\ProductionInspectionSearch;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\SernoInput;

/**
* This is the class for controller "ProductionInspectionController".
*/
class ProductionInspectionController extends \app\controllers\base\ProductionInspectionController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
	    $searchModel  = new ProductionInspectionSearch;
	    $searchModel->proddate = date('Y-m-d');

	    if (\Yii::$app->request->get('prod_date') !== null) {
	    	$searchModel->proddate = \Yii::$app->request->get('prod_date');
	    }

	    if (\Yii::$app->request->get('proddate') !== null) {
	    	$searchModel->proddate = \Yii::$app->request->get('proddate');
	    }

	    if (\Yii::$app->request->get('status') !== null) {
	    	$searchModel->status = \Yii::$app->request->get('status');
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

	public function actionGetProductSerno($proddate, $plan)
	{
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th style="text-align: center;">GMC</th>
			<th>Description</th>
			<th style="text-align: center;">Serial Number</th>
		</tr>'
		;
		$result = SernoInput::find()
		->joinWith('sernoMaster')
		->select([
			'gmc' => 'tb_serno_input.gmc',
			'sernum' => 'sernum',
			'destination' => 'CONCAT(tb_serno_master.model, \' // \', tb_serno_master.color, \' // \', tb_serno_master.dest)'
		])
		->where([
			'proddate' => $proddate,
			'plan' => $plan
		])
		->orderBy('gmc ASC, sernum ASC')
		->all();

		if (count($result) > 0) {
			foreach ($result as $value) {
				$data .= '
				<tr>
					<td style="text-align: center;">' . $value['gmc'] . '</td>
					<td>' . $value['destination'] . '</td>
					<td style="text-align: center;">' . $value['sernum'] . '</td>
				</tr>
				';
			}
		} else {
			$data .= '
			<tr>
				<td colspan="3">No Sparepart Data</td>
			</tr>
			';
		}

		$data .= '</table>';
		return $data;
	}
}
