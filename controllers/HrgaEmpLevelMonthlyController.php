<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\MpInOut;
use yii\helpers\Url;
use yii\web\JsExpression;

class HrgaEmpLevelMonthlyController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		$title = '2018';
		$subtitle = '';
		$data = [];
		$category_arr = [];
		$name_arr = [];

		$menu = 1;

		$name_arr = $this->getDataName($menu);
		$emp_data = $this->getEmployeeData($menu);
		$today_period = date('Ym');

		$period_arr = MpInOut::find()
		->select('DISTINCT(PERIOD)')
		->where([
			'LEFT(PERIOD,4)' => date('Y')
		])
		->all();
		$this_period_qty = 0;
		foreach ($name_arr as $name) {
			$tmp_data = [];
			$split_name_arr = explode('-', $name, 2);
			
			foreach ($period_arr as $period) {
				$tmp_period = $period->PERIOD;
				
				foreach ($emp_data as $value) {
					if ($name == $value->category && $tmp_period == $value->PERIOD) {
						$tmp_data[] = [
							'y' => (int)$value->total_emp,
							'url' => Url::to(['hrga-emp-data/index', 'period' => $tmp_period, 'category' => $value->category]),
						];
						if ($tmp_period == $today_period) {
							$this_period_qty += (int)$value->total_emp;
						}
						
					}
				}
				if (!in_array($tmp_period, $category_arr)) {
					$category_arr[] = $tmp_period;
				}
			}
			
			$data[] = [
				//'name' => explode('-', $name, 2),
				'name' => $menu == 1 ? $split_name_arr[1] : $name,
				'data' => $tmp_data,
				'type' => 'column',
				'yAxis' => 1,
			];
		}

		$working_days = [19, 20, 21, 21, 21, 17, 23, 22, 20, 23, 20, 18];

		$data[] = [
			'name' => 'Speaker',
			'data' => [
				(float)round(69899/19),
				(float)round(71567/20),
				(float)round(75302/21),
				(float)round(91344/21),
				(float)round(97979/21),
				(float)round(78801/17),
				(float)round(114912/23),
				(float)round(100531/22),
				(float)round(93424/20),
				(float)round(94870/23),
				(float)round(82814/20),
				(float)round(71618/18),
			],
			'type' => 'spline',
			'color' => new JsExpression('Highcharts.getOptions().colors[12]'),
		];
		/*$data[] = [
			'name' => 'Other',
			'data' => [
				(float)round(29575/19),
				(float)round(31252/20),
				(float)round(13395/21),
				(float)round(37292/21),
				(float)round(45291/21),
				(float)round(8919/17),
				(float)round(29331/23),
				(float)round(30816/22),
				(float)round(32667/20),
				(float)round(29554/23),
				(float)round(29864/20),
				(float)round(27765/18),
			],
			'type' => 'spline',
		];*/

		foreach ($category_arr as $key => $value) {
			$category_arr[$key] = date('M', strtotime(substr_replace($value, '-', 4, 0)));
		}

		return $this->render('index', [
			'title' => $title,
			'subtitle' => $subtitle,
			'data' => $data,
			'category' => $category_arr,
			'section' => $this->getDepartment(),
			'menu' => $menu,
			'this_period_qty' => $this_period_qty,
		]);
	}

	public function getDataName($menu)
	{
		$category_arr = [];
		if ($menu == 1) {
			$data_arr =  MpInOut::find()
			->select([
				'category' => 'DISTINCT(PKWT)'
			])
			->orderBy('PKWT ASC')
			->all();
		} elseif ($menu == 2) {
			$data_arr =  MpInOut::find()
			->select([
				'category' => 'DISTINCT(DEPARTEMEN)'
			])
			->all();
		}

		foreach ($data_arr as $value) {
			$category_arr[] = $value->category;
		}
		return $category_arr;
	}

	public function getEmployeeData($menu)
	{
		if ($menu == 1) {
			$emp_data = MpInOut::find()
			->select([
				'PERIOD' => 'PERIOD',
				'category' => 'PKWT',
				'total_emp' => 'COUNT(NIK)'
			])
			->where([
				'AKHIR_BULAN' => 'end_of_month',
				'LEFT(PERIOD,4)' => date('Y')
			])
			->groupBy('PERIOD, PKWT')
			->orderBy('PERIOD, PKWT')
			->all();
		} elseif ($menu == 2) {
			$emp_data = MpInOut::find()
			->select([
				'PERIOD' => 'PERIOD',
				'category' => 'DEPARTEMEN',
				'total_emp' => 'COUNT(NIK)'
			])
			->where([
				'AKHIR_BULAN' => 'end_of_month',
				'LEFT(PERIOD,4)' => date('Y')
			])
			->groupBy('PERIOD, DEPARTEMEN')
			->orderBy('PERIOD, DEPARTEMEN')
			->all();
		}

		return $emp_data;
		
	}

	public function getSection()
	{
		$section_arr = [];
		$section_data_arr = MpInOut::find()
		->select('DISTINCT(SECTION)')
		->orderBy('SECTION ASC')
		->all();

		foreach ($section_data_arr as $value) {
			$section_arr[] = $value->SECTION;
		}

		return $section_arr;
	}

	public function getDepartment()
	{
		$section_arr = [];
		$section_data_arr = MpInOut::find()
		->select('DISTINCT(DEPARTEMEN)')
		->orderBy('DEPARTEMEN ASC')
		->all();

		foreach ($section_data_arr as $value) {
			$section_arr[] = $value->DEPARTEMEN;
		}

		return $section_arr;
	}
}