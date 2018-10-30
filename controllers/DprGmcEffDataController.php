<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\DprGmcEffDataSearch;
use app\models\SernoMp;
use app\models\HakAkses;

class DprGmcEffDataController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex()
	{
		$searchModel  = new DprGmcEffDataSearch;
    	if(\Yii::$app->request->get('proddate') !== null)
	    {
	    	$searchModel->proddate = \Yii::$app->request->get('proddate');
	    }
	    if(\Yii::$app->request->get('line') !== null)
	    {
	    	$searchModel->line = \Yii::$app->request->get('line');
	    }
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'line_arr' => $this->getLineArray(),
		]);
	}

	public function getLineArray()
	{
		$data_arr = HakAkses::find()
		->where([
			'level_akses' => '4'
		])
		->andWhere(['<>', 'hak_akses', 'MIS'])
		->all();

		foreach ($data_arr as $value) {
			$line_arr[$value->hak_akses] = $value->hak_akses;
		}

		return $line_arr;
	}

	public function actionGetMpList($proddate = '', $line = '')
	{
		$mp_data_arr = SernoMp::find()
		->where([
			'tgl' => $proddate,
			'line' => $line
		])
		->orderBy('status DESC, cek_in DESC')
		->all();
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th class="text-center">No</th>
			<th class="text-center">NIK</th>
			<th class="text-center">Check In</th>
			<th class="text-center">Check Out</th>
			<th class="text-center">Status</th>
		</tr>'
		;
		$no = 1;
		foreach ($mp_data_arr as $value) {
			if ($value->status == 0) {
				$status = 'IN';
			} else {
				$status = 'OUT';
			}
			$data .= '
			<tr>
				<td class="text-center">' . $no . '</td>
				<td class="text-center">' . $value->nik . '</td>
				<td class="text-center">' . $value->cek_in . '</td>
				<td class="text-center">' . $value->cek_out . '</td>
				<td class="text-center">' . $status . '</td>
			</tr>
			';
			$no++;
		}
		
		$data .= '</table>';
		return $data;
	}
}