<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Karyawan;
use app\models\RekapAbsensiView;

class MyHrController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$nik = \Yii::$app->user->identity->username;
        $model_karyawan = Karyawan::find()->where([
            'NIK' => $nik
        ])->one();
        $model_rekap_absensi = RekapAbsensiView::find()->where(['NIK' => $nik])->orderBy('PERIOD')->all();
		return $this->render('index', [
			'model_karyawan' => $model_karyawan,
            'model_rekap_absensi' => $model_rekap_absensi,
		]);
	}

	public function actionGetLemburDetail($nik, $period)
    {
        $spl_data_arr = SplView::find()
        ->where([
            'NIK' => $nik,
            'PERIOD' => $period
        ])
        ->orderBy('TGL_LEMBUR')
        ->all();

        $data = '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<thead><tr>
            <th style="text-align: center;">No. SPL</th>
            <th style="text-align: center;">Hari Kerja/Libur</th>
            <th style="text-align: center;">Tanggal</th>
            <th style="text-align: center;">Plan Lembur</th>
            <th style="text-align: center;">Aktual Lembur</th>
            <th>Alasan Lembur</th>
        </tr></thead>'
        ;
        $data .= '<tbody>';
        foreach ($spl_data_arr as $key => $value) {
            $data .= '
            <tr>
                <td style="text-align: center;">' . $value->SPL_HDR_ID . '</td>
                <td style="text-align: center;">' . $value->JENIS_LEMBUR . '</td>
                <td style="text-align: center;">' . date('l, d M\' Y', strtotime($value->TGL_LEMBUR)) . '</td>
                <td style="text-align: center;">' . date('H:i', strtotime($value->END_LEMBUR_PLAN)) . ' (' . $value->NILAI_LEMBUR_PLAN . ' jam)</td>
                <td style="text-align: center;">' . date('H:i', strtotime($value->END_LEMBUR_ACTUAL)) . ' (' . $value->NILAI_LEMBUR_ACTUAL . ' jam)</td>
                <td>' . $value->URAIAN_LEMBUR . '</td>
            </tr>
            ';
        }
        $data .= '</tbody>';
        $data .= '</table>';
        return $data;
    }

    public function actionGetDisiplinDetail($nik, $period, $category = 'DISIPLIN')
    {
        if ($category == 'DISIPLIN') {
            $abensi_data_arr = AbsensiTbl::find()->where([
                'NIK' => $nik,
                'PERIOD' => $period,
                'DISIPLIN' => 0
            ])
            ->orderBy('DATE')
            ->all();
        } else {
            /*if ($category == 'alpha') {
                $category = 'ALPHA';
            } elseif ($category == 'ijin') {
                $category = 'IJIN';
            } elseif ($category == 'sakit') {
                $category = 'SAKIT';
            } else {
                $category = 'CUTI';
            }*/
            $abensi_data_arr = AbsensiTbl::find()->where([
                'NIK' => $nik,
                'PERIOD' => $period,
                'CATEGORY' => $category
            ])
            ->orderBy('DATE')
            ->all();
        }
        

        $data = '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<thead><tr>
            <th style="text-align: center;">Tanggal</th>
            <th>Keterangan</th>
        </tr></thead>'
        ;
        $data .= '<tbody>';
        foreach ($abensi_data_arr as $key => $value) {
            $data .= '
            <tr>
                <td style="text-align: center;">' . date('l, d F Y', strtotime($value['DATE'])) . '</td>
                <td>' . $value['CATEGORY'] . '</td>
            </tr>
            ';
        }
        $data .= '</tbody>';
        $data .= '</table>';
        return $data;
    }
}