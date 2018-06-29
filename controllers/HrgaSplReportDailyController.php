<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\SplView;

/**
 * summary
 */
class HrgaSplReportDailyController extends Controller
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$title = 'Title';
    	$subtitle = 'Subtitle';
    	$category = [];
    	$data = [];
    	$cc_group_arr = [];
    	$category_arr = [];
    	$tgl_lembur_arr = [];

    	$cc_group_data = SplView::find()
		->select('DISTINCT(CC_GROUP)')
		->where('CC_GROUP IS NOT NULL')
		->all();

		foreach ($cc_group_data as $value) {
			$cc_group_arr[] = $value->CC_GROUP;
		}

		$tgl_lembur_data = SplView::find()
		->select('DISTINCT(TGL_LEMBUR)')
		->all();

		foreach ($tgl_lembur_data as $value) {
			$tgl_lembur_arr[] = $value->TGL_LEMBUR;
		}

		//print_r($tgl_lembur_arr);

    	$spl_data = SplView::find()
    	->select([
    		'TGL_LEMBUR' => 'TGL_LEMBUR',
    		'CC_GROUP' => 'CC_GROUP',
    		'JUMLAH' => 'COUNT(NIK)',
    	])
    	->where('NIK IS NOT NULL')
    	->groupBy('CC_GROUP, TGL_LEMBUR')
    	->all();

    	foreach ($cc_group_arr as $cc_group) {
    		$tmp_data = [];
    		foreach ($tgl_lembur_arr as $tgl_lembur) {
    			$is_found = false;
                
    			foreach ($spl_data as $value) {
		    		if ($tgl_lembur == $value->TGL_LEMBUR && $cc_group == $value->CC_GROUP) {
                        
		    			$tmp_data[] = [
                            'y' => (int)$value->JUMLAH,
                            'remark' => $this->getDetailEmpRemark($tgl_lembur, $cc_group)
                        ];
		    			$is_found = true;
		    		}
		    	}
		    	if (!$is_found) {
		    		$tmp_data[] = null;
		    	}
		    	if (!in_array($tgl_lembur, $category_arr)) {
					$category_arr[] = $tgl_lembur;
				}
    		}
    		$data[] = [
				'name' => $cc_group,
				'data' => $tmp_data,
			];
    	}

    	foreach ($category_arr as $key => $value) {
    		$category_arr[$key] = date('d-M-Y', strtotime($value));
    	}

    	return $this->render('index', [
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'category' => $category_arr,
    		'data' => $data,
    		'spl_data' => $spl_data
    	]);
    }

    public function getDetailEmpRemark($tgl_lembur, $cc_group)
    {
        $detail_data = $spl_data = SplView::find()
        ->where('NIK IS NOT NULL')
        ->andWhere(['TGL_LEMBUR' => $tgl_lembur, 'CC_GROUP' => $cc_group])
        ->orderBy('CC_GROUP ASC, CC_DESC ASC, NIK ASC')
        ->all();
        $remark = '<h4>' . $cc_group . ' on ' . date('d M\' Y', strtotime($tgl_lembur)) .'</h4>';
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '
        <tr>
            <th style="text-align: center;">NO</th>
            <th style="width:100px; text-align: center;">NIK</th>
            <th>Nama</th>
            <th>Section</th>
        </tr>
        ';
        $i = 1;
        foreach ($detail_data as $detail) {
            if ($tgl_lembur == $detail->TGL_LEMBUR && $cc_group == $detail->CC_GROUP) {
                $remark .= '
                <tr>
                    <td style="text-align: center;">' . $i . '</td>
                    <td style="text-align: center;">' . $detail->NIK . '</td>
                    <td>' . $detail->NAMA_KARYAWAN . '</td>
                    <td>' . $detail->CC_DESC . '</td>
                </tr>
                ';
                $i++;
            }
        }

        return $remark;
    }
}