<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

use app\models\SplView;
use app\models\Karyawan;
use app\models\CostCenter;
use app\models\FiscalTbl;

class MonthlyOvertimeBySectionController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$categories = $data = [];
    	$model = new \yii\base\DynamicModel([
            'section', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','section'], 'required');

		$section_arr = ArrayHelper::map(CostCenter::find()->select('CC_ID, CC_DESC')->groupBy('CC_ID, CC_DESC')->orderBy('CC_DESC')->all(), 'CC_ID', 'CC_DESC');
		$section_arr['ALL'] = '-- ALL SECTIONS --';
		//asort($section_arr);

		if ($model->load($_GET)) {
			$section = $model->section;
			$tmp_categories = SplView::find()
			->select('PERIOD')
			->where(['>=', 'PERIOD', date('Ym', strtotime($model->from_date))])
			->andWhere(['<=', 'PERIOD', date('Ym', strtotime($model->to_date))])
			->groupBy('PERIOD')
			->all();
			
			foreach ($tmp_categories as $key => $value) {
				$categories[] = $value->PERIOD;
			}
			if ($section == 'ALL') {
				$karyawan_arr = SplView::find()
				->select([
					'NIK', 'NAMA_KARYAWAN', 'CC_ID', 'CC_DESC'
				])
				->where([
					'PERIOD' => $categories,
				])
				->andWhere('NIK IS NOT NULL')
				->groupBy('NIK, NAMA_KARYAWAN, CC_ID, CC_DESC')
				->asArray()
				->all();

				$overtime_data = SplView::find()
				->select([
					'PERIOD',
					'NIK',
					'NAMA_KARYAWAN',
					'CC_ID',
					'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
				])
				->where([
					'PERIOD' => $categories,
				])
				->groupBy('PERIOD, NIK, NAMA_KARYAWAN, CC_ID')
				->orderBy('NIK, PERIOD')
				->asArray()
				->all();
			} else {
				$karyawan_arr = SplView::find()
				->select([
					'NIK', 'NAMA_KARYAWAN', 'CC_ID', 'CC_DESC'
				])
				->where([
					'CC_ID' => $section,
					'PERIOD' => $categories,
				])
				->andWhere('NIK IS NOT NULL')
				->groupBy('NIK, NAMA_KARYAWAN, CC_ID, CC_DESC')
				->asArray()
				->all();

				$overtime_data = SplView::find()
				->select([
					'PERIOD',
					'NIK',
					'NAMA_KARYAWAN',
					'CC_ID',
					'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
				])
				->where([
					'PERIOD' => $categories,
					'CC_ID' => $section
				])
				->groupBy('PERIOD, NIK, NAMA_KARYAWAN, CC_ID')
				->orderBy('NIK, PERIOD')
				->asArray()
				->all();
			}

			foreach ($karyawan_arr as $karyawan) {
				$tmp_data = [];
				foreach ($categories as $period_value) {
					$hour = 0;
					foreach ($overtime_data as $value) {
						if ($value['NIK'] == $karyawan['NIK'] && $period_value == $value['PERIOD']) {
							$hour = $value['NILAI_LEMBUR_ACTUAL'];
							continue;
						}
					}
					$tmp_data[] = [
						'y' => round($hour, 2),
						'url' => Url::to(['get-remark', 'nik' => $karyawan['NIK'], 'nama_karyawan' => $karyawan['NAMA_KARYAWAN'], 'period' => $period_value])
					];
				}
				$data[] = [
					'name' => $karyawan['NIK'] . ' - ' . $karyawan['NAMA_KARYAWAN'] . ' (' . $karyawan['CC_DESC'] . ')',
					'data' => $tmp_data,
					'showInLegend' => false,
					'lineWidth' => 0.8,
					'color' => new JsExpression('Highcharts.getOptions().colors[0]')
				];
			}
		}

    	return $this->render('index', [
			'data' => $data,
			'model' => $model,
			'section' => $section,
			'categories' => $categories,
			'section_arr' => $section_arr
		]);
    }

    public function actionGetRemark($nik, $nama_karyawan, $period)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>' . $nama_karyawan . ' <small>(' . $period . ')</small></h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th class="text-center">Date</th>
	    	<th class="text-center">Check In</th>
	    	<th class="text-center">Check Out</th>
	    	<th class="text-center">Total Hour</th>
	    	<th>Job Desc.</th>
	    </tr>';

	    $overtime_data_arr = SplView::find()
	    ->where([
	    	'NIK' => $nik,
	    	'PERIOD' => $period,
	    ])
	    ->orderBy('TGL_LEMBUR')
	    ->all();

	    $no = 1;
	    foreach ($overtime_data_arr as $key => $value) {

	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . date('Y-m-d', strtotime($value->TGL_LEMBUR)) . '</td>
	    		<td class="text-center">' . date('H:i:s', strtotime($value->START_LEMBUR_ACTUAL)) . '</td>
	    		<td class="text-center">' . date('H:i:s', strtotime($value->END_LEMBUR_ACTUAL)) . '</td>
	    		<td class="text-center">' . $value->NILAI_LEMBUR_ACTUAL . '</td>
	    		<td>' . $value->KETERANGAN . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}