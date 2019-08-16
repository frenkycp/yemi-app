<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\SplViewMonthlySection02;
use app\models\SplHdr;
use app\models\FiscalTbl;

class SectionOvertimeRangeController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$data = [];
        $categories = [];

        $model = new \yii\base\DynamicModel([
            'section', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','section'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d') . '-1 year'));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

        $section_arr = ArrayHelper::map(SplHdr::find()->select('CC_DESC')->where('CC_DESC IS NOT NULL')->groupBy('CC_DESC')->orderBy('CC_DESC')->all(), 'CC_DESC', 'CC_DESC');

        if ($model->load($_GET)) {
        	$fiscal_data = FiscalTbl::find()
        	->select(['PERIOD'])
        	->where([
        		'AND',
        		['>=', 'PERIOD', date('Ym', strtotime($model->from_date))],
        		['<=', 'PERIOD', date('Ym', strtotime($model->to_date))]
        	])
        	->orderBy('PERIOD')
        	->all();

        	foreach ($fiscal_data as $key => $value) {
        		$categories[] = $value->PERIOD;
        	}

        	$tmp_data1 = SplViewMonthlySection02::find()
	        ->select(['PERIOD', 'CC_DESC', 'lembur_total'])
	        ->where([
	        	'PERIOD' => $categories,
	        	'CC_DESC' => $model->section
	        ])
	        ->orderBy('PERIOD')
	        ->all();

	        foreach ($categories as $period_value) {
	        	$lembur_total = 0;
	        	foreach ($tmp_data1 as $value) {
		        	if ($value->PERIOD == $period_value) {
		        		$lembur_total = $value->lembur_total;
		        		break;
		        	}
		        }
		        $tmp_data[] = [
					'y' => $lembur_total,
					//'url' => Url::to(['get-remark', 'nik' => $karyawan['NIK'], 'nama_karyawan' => $karyawan['NAMA_KARYAWAN'], 'period' => $period_value])
				];
	        }
	        $data[] = [
	        	'name' => 'Overtime Total',
	        	'data' => $tmp_data,
	        	'showInLegend' => false,
	        ];
	        
        }

		return $this->render('index', [
			'model' => $model,
			'data' => $data,
			'categories' => $categories,
			'section_arr' => $section_arr,
		]);
	}
}