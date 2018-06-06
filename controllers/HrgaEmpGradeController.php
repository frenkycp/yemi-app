<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\MpInOut;

class HrgaEmpGradeController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$title = 'Employee Grade Structure';
    	$subtitle = '';
    	$data = [];
    	$emp_data_male = [];
    	$emp_data_female = [];

    	$sr_grade = [
    		'G1', 'G2',
    		'E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7', 'E8',
    		'L1', 'L2', 'L3', 'L4',
    		'M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'M7', 'M8',
    		'D1', 'D2', 'D3'
    	];

    	$categories = [
		    '0-4', '5-9', '10-14', '15-19',
		    '20-24', '25-29', '30-34', '35-39', '40-44',
		    '45-49', '50-54', '55-59', '60-64', '65-69',
		    '70-74', '75-79', '80-84', '85-89', '90-94',
		    '95-99', '100 + '
		];

		$jk_arr = ['L', 'P'];

		$emp_data = MpInOut::find()
		->select([
			'GRADE' => 'GRADE',
			'JENIS_KELAMIN' => 'JENIS_KELAMIN',
			'total_emp' => 'COUNT(*)'
		])
		->where([
			'TANGGAL' => date('Y-m-d')
		])
		->groupBy('GRADE, JENIS_KELAMIN')
		->all();

		foreach ($jk_arr as $jk) {
			$tmp_data = [];
			foreach ($sr_grade as $grade) {
				$tmp_qty = null;
				foreach ($emp_data as $value) {
					$tmp_grade = $value->GRADE;
					$tmp_jk = $value->JENIS_KELAMIN;
					if ($tmp_grade == $grade && $tmp_jk == $jk) {
						$tmp_qty = (int)$value->total_emp;
						if ($jk == 'L') {
							$tmp_qty = (-1 * $tmp_qty);
						}
					}
				}
				$tmp_data[] = $tmp_qty;
			}
			$data[] = [
				'name' => $jk == 'L' ? 'Male' : 'Female',
				'data' => $tmp_data
			];
		}
		

    	return $this->render('index', [
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'categories' => $sr_grade,
    		'data' => $data
    	]);
    }
}