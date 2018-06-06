<?php

namespace app\controllers;

use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\MesinCheckDtrSearch;
use app\models\MesinCheckTbl;
use app\models\MasterplanHistory;

/**
* This is the class for controller "MesinCheckDtrController".
*/
class MesinCheckDtrController extends \app\controllers\base\MesinCheckDtrController
{
	
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new MesinCheckDtrSearch;
	    if (\Yii::$app->request->get('master_plan_maintenance') !== null) {
	    	$searchModel->master_plan_maintenance = \Yii::$app->request->get('master_plan_maintenance');
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

	public function actionGetCheckSheet($mesin_id, $mesin_periode)
	{
		$check_sheet = MesinCheckTbl::find()->where(['mesin_id' => $mesin_id, 'mesin_periode' => $mesin_periode])->all();

		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= '
		<tr>
			<th>Machine ID</th>
			<th style="width:100px;">Periode</th>
			<th>Machine Name</th>
			<th>No</th>
			<th>Machine Part</th>
			<th>Check Remark</th>
		</tr>
		';

		foreach ($check_sheet as $value) {
			$data .= '
			<tr>
				<td>' . $value->mesin_id . '</td>
				<td>' . $value->mesin_periode . '</td>
				<td>' . $value->mesin_nama . '</td>
				<td>' . $value->mesin_no . '</td>
				<td>' . $value->mesin_bagian . '</td>
				<td>' . $value->mesin_bagian_ket . '</td>
			</tr>
			';
		}

		$data .= '</table>';

		return $data;
	}

	/*public function actionGetHistory($mesin_id, $mesin_periode)
	{
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= '
		<tr>
			<th>Machine ID</th>
			<th>Machine Name</th>
			<th style="width:100px;">Periode</th>
			<th>Location</th>
			<th>Area</th>
			<th>Last Check</th>
		</tr>
		';

		$history = MasterplanHistory::find()->where(['mesin_id' => $mesin_id, 'mesin_periode' => $mesin_periode])->all();

		foreach ($history as $value) {
			$data .= '
			<tr>
				<td>' . $value->mesin_id . '</td>
				<td>' . $value->mesin_nama . '</td>
				<td>' . $value->mesin_periode . '</td>
				<td>' . $value->location . '</td>
				<td>' . $value->area . '</td>
				<td>' . date('d-M-Y H:i:s', strtotime($value->mesin_last_update)) . '</td>
			</tr>
			';
		}

		return $data;
	}*/
}
