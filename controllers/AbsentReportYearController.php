<?php
namespace app\controllers;

use app\models\AbsensiTbl;
use app\models\search\AbsentReportYearSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
 * summary
 */
class AbsentReportYearController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$searchModel  = new AbsentReportYearSearch;

    	$searchModel->YEAR = date('Y');
	    if (\Yii::$app->request->post('YEAR') != null) {
	    	$searchModel->YEAR = \Yii::$app->request->post('YEAR');
	    }

	    $searchModel->NOTE = 'DL';
	    if (\Yii::$app->request->post('NOTE') != null) {
	    	$searchModel->NOTE = \Yii::$app->request->post('NOTE');
	    }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'filter_category' => $filter_category,
		]);
    }

    public function actionGetDisiplinDetail($nik, $nama_karyawan, $year, $note = 'DISIPLIN')
    {
        if ($note == 'DISIPLIN') {
            $abensi_data_arr = AbsensiTbl::find()->where([
                'NIK' => $nik,
                'YEAR' => $year,
                'DISIPLIN' => 0
            ])
            ->orderBy('DATE')
            ->all();
        } else {
            if ($note == 'CK') {
                $abensi_data_arr = AbsensiTbl::find()->where([
                    'NIK' => $nik,
                    'YEAR' => $year,
                    'NOTE' => ['CK', 'CK1', 'CK3', 'CK5', 'CK7', 'CK10', 'CK11']
                ])
                ->orderBy('DATE')
                ->all();
            } else {
                $abensi_data_arr = AbsensiTbl::find()->where([
                    'NIK' => $nik,
                    'YEAR' => $year,
                    'NOTE' => $note
                ])
                ->orderBy('DATE')
                ->all();
            }
            
        }
        
        $data = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $nik . ' - ' . $nama_karyawan . ' <small>(' . $year . ')</small></h3>
        </div>
        <div class="modal-body">
        ';

        $data .= '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<thead><tr>
            <th class="text-center">Date</th>
            <th class="text-center">Description</th>
            <th class="text-center">Check In</th>
            <th class="text-center">Check Out</th>
        </tr></thead>'
        ;
        $data .= '<tbody>';
        foreach ($abensi_data_arr as $key => $value) {
            $keterangan = '-';
            if ($value['NOTE'] == 'S') {
                $keterangan = 'SICK';
            } elseif ($value['NOTE'] == 'I') {
                $keterangan = 'PERMIT';
            } elseif ($value['NOTE'] == 'A') {
                $keterangan = 'ABSENT';
            } elseif ($value['NOTE'] == 'C') {
                $keterangan = 'ON LEAVE';
            } elseif ($value['NOTE'] == 'DL') {
                $keterangan = 'COME LATE';
            } elseif ($value['NOTE'] == 'PC') {
                $keterangan = 'GO HOME EARLY';
            } else {
                $keterangan = $value['CATEGORY'];
            }

            $check_in = $value['CHECK_IN'];
            $check_out = $value['CHECK_OUT'];

            if ($check_in > $check_out) {
                $tmp = $check_in;
                $check_in = $check_out;
                $check_out = $tmp;
            }
            $check_in = $value['CHECK_IN'] == null ? '-' : date('H:i:s', strtotime($check_in));
            $check_out = $value['CHECK_OUT'] == null ? '-' : date('H:i:s', strtotime($check_out));
            $data .= '
            <tr>
                <td class="text-center">' . date('d M\' Y', strtotime($value['DATE'])) . '</td>
                <td class="text-center">' . $keterangan . '</td>
                <td class="text-center">' . $check_in . '</td>
                <td class="text-center">' . $check_out . '</td>
            </tr>
            ';
        }
        $data .= '</tbody>';
        $data .= '</table>';
        return $data;
    }
}