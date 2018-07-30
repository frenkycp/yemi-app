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

	public function actionGetProductSerno($flo, $status)
	{
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th style="text-align: center;">Serial Number</th>
			<th style="text-align: center;">NG Status</th>
		</tr>'
		;

		if ($status == 'Open') {
			$condition = [
				'qa_ng' => '',
				'qa_ok' => ''
			];
		} elseif ($status == 'OK') {
			$condition = [
				'qa_ng' => '',
				'qa_ok' => 'OK'
			];
		} elseif ($status == 'Repair') {
			$condition = 'qa_ng != \'\' AND qa_result = 2';
		} elseif ($status == 'Lot Out') {
			$condition = 'qa_ng != \'\' AND qa_result = 2';
		}

		if ($status == 'Repair') {
			$result = SernoInput::find()
			//->joinWith('sernoMaster')
			/*->select([
				'gmc' => 'tb_serno_input.gmc',
				'sernum' => 'sernum',
				'destination' => 'CONCAT(tb_serno_master.model, \' // \', tb_serno_master.color, \' // \', tb_serno_master.dest)'
			])*/
			->where([
				'flo' => $flo
			])
			->andWhere('qa_ng != \'\' AND qa_result = 2')
			->orderBy('sernum ASC')
			->all();
		} else {
			$result = SernoInput::find()
			//->joinWith('sernoMaster')
			/*->select([
				'gmc' => 'tb_serno_input.gmc',
				'sernum' => 'sernum',
				'destination' => 'CONCAT(tb_serno_master.model, \' // \', tb_serno_master.color, \' // \', tb_serno_master.dest)'
			])*/
			->where([
				'flo' => $flo
			])
			->orderBy('sernum ASC')
			->all();
		}

		if (count($result) > 0) {
			foreach ($result as $value) {
				$ng_status = '';
				$class = '';
				if ($value->qa_result != 0) {
					$ng_status = '<b>Not Good</b>';
					$class = 'danger';
				}
				$data .= '
				<tr class="' . $class . '">
					<td style="text-align: center;">' . $value['sernum'] . '</td>
					<td style="text-align: center;">' . $ng_status . '</td>
				</tr>
				';
			}
		} else {
			$data .= '
			<tr>
				<td colspan="1">No Serno Data</td>
			</tr>
			';
		}

		$data .= '</table>';
		return $data;
	}

	public function actionGetNgDetail($proddate, $plan)
	{
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th style="text-align: center;">GMC</th>
			<th>Description</th>
			<th style="text-align: center;">Serial Number</th>
			<th style="text-align: center;">Remark Date</th>
			<th>NG Remark</th>
		</tr>'
		;
		$result = SernoInput::find()
		->joinWith('sernoMaster')
		->select([
			'gmc' => 'tb_serno_input.gmc',
			'sernum' => 'sernum',
			'destination' => 'CONCAT(tb_serno_master.model, \' // \', tb_serno_master.color, \' // \', tb_serno_master.dest)',
			'qa_ng' => 'qa_ng',
			'qa_ng_date' => 'qa_ng_date'
		])
		->where([
			'proddate' => $proddate,
			'plan' => $plan,
		])
		->andWhere(['<>', 'qa_ng', ''])
		->andWhere(['<>', 'flo', 0])
		->orderBy('gmc ASC, sernum ASC')
		->all();

		if (count($result) > 0) {
			foreach ($result as $value) {
				$data .= '
				<tr>
					<td style="text-align: center;">' . $value['gmc'] . '</td>
					<td>' . $value['destination'] . '</td>
					<td style="text-align: center;">' . $value['sernum'] . '</td>
					<td style="text-align: center;">' . $value['qa_ng_date'] . '</td>
					<td>' . $value['qa_ng'] . '</td>
				</tr>
				';
			}
		} else {
			$data .= '
			<tr>
				<td colspan="5">No NG Data</td>
			</tr>
			';
		}

		$data .= '</table>';
		return $data;
	}
}
