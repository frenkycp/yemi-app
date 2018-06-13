<?php

namespace app\controllers;

use app\models\search\MesinCheckNgSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* This is the class for controller "MesinCheckNgController".
*/
class MesinCheckNgController extends \app\controllers\base\MesinCheckNgController
{
	
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new MesinCheckNgSearch;
	    if (\Yii::$app->request->get('mesin_last_update') !== null) {
	    	$searchModel->mesin_last_update = \Yii::$app->request->get('mesin_last_update');
	    }
	    if (\Yii::$app->request->get('repair_status') !== null) {
	    	$searchModel->repair_status = \Yii::$app->request->get('repair_status');
	    }
	    if (\Yii::$app->request->get('ticket_no') !== null) {
	    	$searchModel->urutan = \Yii::$app->request->get('ticket_no');
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

	public function actionGetSparePart($mesin_id = 'MNT00481')
	{
		$sql = "{CALL SPARE_PART_STOCK(:MACHINE)}";
		// passing the params into to the sql query
		$params = [':MACHINE'=>$mesin_id];
		// execute the sql command
		$result = \Yii::$app->db_wsus->createCommand($sql, $params)->queryAll();
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th>Machine ID</th>
			<th>Item</th>
			<th>Item Description</th>
			<th>UM</th>
			<th>ON HAND</th>
			<th>PO</th>
			<th>IMR</th>
		</tr>'
		;
		if (count($result) > 0) {
			foreach ($result as $value) {
				$data .= '
				<tr>
					<td>' . $value['MACHINE'] . '</td>
					<td>' . $value['ITEM'] . '</td>
					<td>' . $value['ITEM_DESC'] . '</td>
					<td>' . $value['UM'] . '</td>
					<td>' . $value['ONHAND'] . '</td>
					<td>' . $value['PO'] . '</td>
					<td>' . $value['IMR'] . '</td>
				</tr>
				';
			}
		} else {
			$data .= '
			<tr>
				<td colspan="7">No Sparepart Data</td>
			</tr>
			';
		}
		
		$data .= '</table>';
		return $data;
	}

	public function actionUpdate($urutan)
	{
		$model = $this->findModel($urutan);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
}
