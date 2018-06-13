<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\MpInOut;
use yii\helpers\Url;

/**
 * summary
 */
class HrgaEmpJabatanController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
    	$title = '';
    	$subtitle = '';
    	$data = [];
    	$categories = [];

    	$jabatan_arr = [
    		'01-NON POSITION-KONTRAK',
    		'01-NON POSITION-TETAP',
    		'02-SUBLEADER',
			'03-LEADER',
			'04-FOREMAN/CHIEF',
			'05-SENIOR FOREMAN/ASSISTANT MANAGER',
			'06-MANAGER',
			'07-DEPUTY GM',
			'08-GM',
			'09-GM&DIRECTOR'
    	];

    	$japanesse_arr = [
    		'（役職無し・契約）',
    		'（役職無し・正）',
    		'（サブリーダー）',
    		'（リーダー）',
    		'（フォアマン・チーフ）',
    		'（シニアフォアマン・副課長）',
    		'（課長）',
    		'（副部長）',
    		'（部長）',
    		'（部長・取締役）',
    	];

    	$emp_data = MpInOut::find()
		->select([
			'JABATAN_SR_GROUP' => 'JABATAN_SR_GROUP',
			'total_emp' => 'COUNT(*)'
		])
		->where([
			'TANGGAL' => date('Y-m-d')
		])
		->groupBy('JABATAN_SR_GROUP')
		->all();

		foreach ($jabatan_arr as $key => $jabatan) {
			$categories[] = substr($jabatan, strpos($jabatan, "-") + 1) . $japanesse_arr[$key];
			$total_qty = 0;
			foreach ($emp_data as $emp) {
				if ($jabatan == $emp->JABATAN_SR_GROUP) {
					$total_qty += (int)$emp->total_emp;
				}
			}
			$data[] = [
    			'y' => $total_qty,
    			'url' => Url::to(['hrga-emp-data/index', 'tanggal' => date('Y-m-d'), 'jabatan' => $jabatan]),
    		];
		}



        return $this->render('index', [
        	'title' => $title,
        	'subtitle' => $subtitle,
        	'data' => $data,
        	'categories' => $categories
        ]);
    }
}