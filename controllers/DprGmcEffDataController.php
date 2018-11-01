<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\DprGmcEffDataSearch;
use app\models\SernoMp;
use app\models\SernoInput;
use app\models\HakAkses;
use app\models\Karyawan;

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
			'line' => $line,
			'status' => 0
		])
		->orderBy('status DESC, cek_in DESC')
		->all();
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th class="text-center">No</th>
			<th class="text-center">NIK</th>
			<th>Name</th>
			<th class="text-center">Check In</th>
			<th class="text-center">Check Out</th>
			<th class="text-center">Status</th>
		</tr>'
		;

		$data_karyawan_arr = ArrayHelper::map(Karyawan::find()->all(), 'NIK', 'NAMA_KARYAWAN');

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
				<td>' . $data_karyawan_arr[$value->nik] . '</td>
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

	public function actionGetProductList($proddate, $line, $gmc)
	{
		$serno_input_arr = SernoInput::find()
		->where([
			'proddate' => $proddate,
			'line' => $line,
			'gmc' => $gmc,
		])
		->all();

		$data = '<table class="table table-bordered table-hover">';
        $data .= 
        '<thead style=""><tr class="info">
        	<th class="text-center">No.</th>
            <th class="text-center">Line</th>
            <th class="text-center">GMC</th>
            <th class="text-center">Description</th>
            <th class="text-center">Serial Num.</th>
            <th class="text-center">End Time</th>
            <th class="text-center">Working Time</th>
            <th class="text-center">MP Time</th>
        </tr></thead>';
        $data .= '<tbody style="">';

        $no = 1;
		foreach ($serno_input_arr as $value) {
			$data .= '
                <tr>
                	<td class="text-center">' . $no . '</td>
                    <td class="text-center">' . $value->line . '</td>
                    <td class="text-center">' . $value->gmc . '</td>
                    <td class="text-center">' . $value->partName . '</td>
                    <td class="text-center">' . $value->sernum . '</td>
                    <td class="text-center">' . $value->waktu . '</td>
                    <td class="text-center">' . $value->wrk_time . '</td>
                    <td class="text-center">' . $value->mp_time . '</td>
                </tr>
            ';
            $no++;
		}

		$data .= '</tbody>';

        $data .= '</table>';
        return $data;
	}
}