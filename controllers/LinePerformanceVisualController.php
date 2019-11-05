<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\SernoInput;
use app\models\HakAkses;
use app\models\DprGmcEffView;
use app\models\SernoMp;
use yii\helpers\ArrayHelper;

/**
 * 
 */
class LinePerformanceVisualController extends Controller
{
	public function actionIndexUpdate($line)
	{
		date_default_timezone_set('Asia/Jakarta');
		
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
		->one();

		$currently_running = null;
		if ($currently_running_arr->gmc != null) {
			$currently_running = $currently_running_arr;
		}

		$current_eff = 0;
		if ($currently_running->mp_time > 0) {
			$current_eff = round(($currently_running->qty_time / $currently_running->mp_time) * 100);
		}

		$last_production_time = gmdate('H:i:s', ($currently_running->wrk_time * 60));

		$master = $currently_running->sernoMaster;
		$avg_eff = round($master->eff);
		$currently_model = '-';
		if ($master->model != null) {
			$currently_model = $master->model;
		}
		
		if ($master->color != '') {
			$currently_model .= ' // ' . $master->color;
		}
		if ($master->dest != '') {
			$currently_model .= ' // ' . $master->dest;
		}

		$gmc = '-';
		if ($master->gmc != null) {
			$gmc = $master->gmc;
		}

		$tmp_total = $this->getTotalEfficiency(date('Y-m-d'), $line, $gmc);
		$total_production_time = gmdate('H:i:s', ($tmp_total[1] * 60));

		$avg_min = $avg_eff - 3;
		$avg_max = $avg_eff + 3;

		if ($gmc == '-') {
			$text = '-';
			$panel_class = 'success';
			$text_class = 'text-green';
		} else {
			if ($current_eff >= $avg_max) {
				$text = '"BAGUS"';
				$panel_class = 'success';
				$text_class = 'text-green';
			} else {
				if ($current_eff >= $avg_min) {
					$text = '"MASUK"';
					$panel_class = 'warning';
					$text_class = 'text-yellow';
				} else {
					$text = '"AYO KAIZEN...!"';
					$panel_class = 'danger';
					$text_class = 'text-danger';
				}
			}
		}

		$current_eff_width = $current_eff;
		if ($current_eff_width > 100) {
			$current_eff_width = 100;
		}

		$progress_content = '<div class="progress-bar progress-bar-striped progress-bar-' . $panel_class . ' active" role="progressbar" aria-valuenow="' . $current_eff . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $current_eff_width . '%; padding: 15px; font-size: 35px;">' . $current_eff . '%</div>';
		$text_bagus_content = '<span style="font-size: 4em; font-weight: bold; text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;" class="' . $text_class . '">' . $text . '</span>';

		$data = [
			'currently_model' => $currently_model,
			'line' => $line,
			'last_production_time' => $last_production_time,
			'total_production_time' => $total_production_time,
			'current_eff' => $current_eff,
			'avg_eff' => $avg_eff,
			'line_dropdown' => $line_dropdown,
			'gmc' => $gmc,
			'mp' => $this->getTotalMp(date('Y-m-d'), $line),
			'total_eff' => $tmp_total[0],
			'progress_content' => $progress_content,
			'text_bagus_content' => $text_bagus_content,
			'last_update' => date('Y-m-d H:i:s'),
		];

		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}

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
		->one();

		$currently_running = null;
		if ($currently_running_arr->gmc != null) {
			$currently_running = $currently_running_arr;
		}

		$current_eff = 0;
		if ($currently_running->mp_time > 0) {
			$current_eff = round(($currently_running->qty_time / $currently_running->mp_time) * 100);
		}

		$last_production_time = gmdate('H:i:s', ($currently_running->wrk_time * 60));

		$master = $currently_running->sernoMaster;
		$avg_eff = round($master->eff);
		$currently_model = '-';
		if ($master->model != null) {
			$currently_model = $master->model;
		}
		
		if ($master->color != '') {
			$currently_model .= ' // ' . $master->color;
		}
		if ($master->dest != '') {
			$currently_model .= ' // ' . $master->dest;
		}

		//$total_production_time = gmdate('H:i:s', ($total_production_time * 60));
		$gmc = '-';
		if ($master->gmc != null) {
			$gmc = $master->gmc;
		}

		$tmp_total = $this->getTotalEfficiency(date('Y-m-d'), $line, $gmc);
		$total_production_time = gmdate('H:i:s', ($tmp_total[1] * 60));

		return $this->render('index', [
			'currently_model' => $currently_model,
			'line' => $line,
			'last_production_time' => $last_production_time,
			'total_production_time' => $total_production_time,
			'total_mp' => $total_mp,
			'current_eff' => $current_eff,
			'avg_eff' => $avg_eff,
			'line_dropdown' => $line_dropdown,
			'gmc' => $gmc,
			'mp' => $this->getTotalMp(date('Y-m-d'), $line),
			'total_eff' => $tmp_total[0],
		]);
	}

	public function getTotalEfficiency($proddate, $line, $gmc)
	{
		$tmp_eff = SernoInput::find()
		->select([
			'qty_time' => 'ROUND(SUM(qty_time),2)',
    		'mp_time' => 'ROUND(SUM(mp_time),2)',
    		'wrk_time' => 'ROUND(SUM(wrk_time),2)'
		])
		->where([
			'proddate' => $proddate,
			'line' => $line,
			'gmc' => $gmc,
		])
		->one();

		$eff = 0;
		if ($tmp_eff->mp_time > 0) {
            $eff = round(($tmp_eff->qty_time / $tmp_eff->mp_time) * 100, 1);
        }
        return [$eff, $tmp_eff->wrk_time];
	}

	public function getTotalMp($proddate, $line)
	{
		$count = SernoMp::find()
		->where([
			'tgl' => $proddate,
			'line' => $line,
			'status' => 0,
		])
		->count();

		return $count;
	}

}