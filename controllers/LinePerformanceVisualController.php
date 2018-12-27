<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\SernoInput;
use app\models\HakAkses;
use app\models\DprGmcEffView;
use yii\helpers\ArrayHelper;

/**
 * 
 */
class LinePerformanceVisualController extends Controller
{
	public function actionIndex()
	{
		$this->layout = 'clean';
		$data = [];
		$line = '';
		
		if (isset($_GET['line'])) {
			$line = $_GET['line'];
		} else {
			$line = $_GET['line'] = 'HS';
		}

		$line_dropdown = ArrayHelper::map($data_arr = HakAkses::find()
		->where(['level_akses' => '4'])
		->orderBy('hak_akses')
		->all(), 'hak_akses', 'hak_akses');

		$currently_running_arr = SernoInput::find()
		->where([
			'proddate' => date('Y-m-d'),
			'line' => $line
		])
		->orderBy('waktu DESC')
		->all();

		$currently_running = null;
		$total_production_time = 0;
		$total_mp = 0;
		foreach ($currently_running_arr as $value) {
			if ($currently_running == null) {
				$currently_running = $value;
			}
			$total_production_time += $value->wrk_time;
			$total_mp = $value->mp;
		}

		$current_eff = 0;
		if ($currently_running->mp_time > 0) {
			$current_eff = round(($currently_running->qty_time / $currently_running->mp_time) * 100);
		}

		$last_production_time = gmdate('H:i:s', ($currently_running->wrk_time * 60));

		$master = $currently_running->sernoMaster;
		$avg_eff = $master->eff;
		$currently_model = $master->model;
		if ($master->color != '') {
			$currently_model .= ' // ' . $master->color;
		}
		if ($master->dest != '') {
			$currently_model .= ' // ' . $master->dest;
		}

		$total_production_time = gmdate('H:i:s', ($total_production_time * 60));

		return $this->render('index', [
			'data' => $data,
			'currently_model' => $currently_model,
			'line' => $line,
			'last_production_time' => $last_production_time,
			'total_production_time' => $total_production_time,
			'total_mp' => $total_mp,
			'current_eff' => $current_eff,
			'avg_eff' => $avg_eff,
			'line_dropdown' => $line_dropdown,
			'gmc' => $master->gmc,
			'mp' => $currently_running->mp,
		]);
	}

	public function getAvgGmcEff($gmc)
	{
		/**/$tmp_data = DprGmcEffView::find()
		->select([
			'efficiency' => 'AVG(efficiency)'
		])
		->where(['>', 'proddate', date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'))])
		->andWhere(['<', 'proddate', date('Y-m-d')])
		->andWhere(['gmc' => $gmc])
		->one();

		return round($tmp_data->efficiency);
		///return 70;
	}

	public function actionUpdateData()
	{
		if (Yii::$app->request->isAjax) {
		    $data = Yii::$app->request->post();
		    $gmc = explode(":", $data['gmc']);
		    $gmc = $gmc[0];
		    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		    return [
		        'search' => $search,
		        'code' => 100,
		    ];
  		}
	}
}