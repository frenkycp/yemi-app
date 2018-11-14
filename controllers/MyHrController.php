<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Karyawan;
use app\models\RekapAbsensiView;
use app\models\CutiRekapView02;
use app\models\SplView;
use app\models\AbsensiTbl;
use yii\helpers\Url;

class MyHrController extends Controller
{
	/*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/

	public function actionIndex()
	{
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }
        $this->layout = 'my-hr';
		//$nik = \Yii::$app->request->get('nik');
        $nik = $session['my_hr_user'];
        $model_karyawan = Karyawan::find()->where([
            'NIK' => $nik
        ])->one();
        $model_rekap_absensi = RekapAbsensiView::find()->where([
            'NIK' => $nik,
            'YEAR' => date('Y')
        ])
        ->orderBy('PERIOD')
        ->all();

        $rekap_cuti_arr = CutiRekapView02::find()
        ->where([
            'TAHUN' => date('Y'),
            'NIK' => $nik
        ])
        ->all();

        $using_cuti = 0;
        $kuota_cuti = 0;
        foreach ($rekap_cuti_arr as $rekap_cuti) {
            if ($rekap_cuti->TYPE == '01-KUOTA') {
                $kuota_cuti += $rekap_cuti->JUMLAH_CUTI;
            } else {
                $using_cuti += $rekap_cuti->JUMLAH_CUTI;
            }
        }
        $sisa_cuti = $kuota_cuti + $using_cuti;
        if ($sisa_cuti < 0) {
            $sisa_cuti = 0;
        }

		return $this->render('index', [
			'model_karyawan' => $model_karyawan,
            'model_rekap_absensi' => $model_rekap_absensi,
            'using_cuti' => $using_cuti,
            'kuota_cuti' => $kuota_cuti,
            'sisa_cuti' => $sisa_cuti,
		]);
	}

    public function actionLogin()
    {
        $session = \Yii::$app->session;
        if ($session->has('my_hr_user')) {
            return $this->redirect(['index']);
        }
        $this->layout = "adminty\my-hr-login";

        $model = new \yii\base\DynamicModel([
            'username', 'password'
        ]);
        $model->addRule(['username', 'password'], 'required');

        if($model->load(\Yii::$app->request->post())){
            $karyawan = Karyawan::find()
            ->where([
                'NIK' => $model->username,
                'PASSWORD' => $model->password,
            ])
            ->one();
            if ($karyawan->NIK !== null) {
                $session['my_hr_user'] = $model->username;
                return $this->redirect(['index']);
            } else {
                \Yii::$app->getSession()->setFlash('error', 'Incorrect username or password...');
            }
            $model->username = null;
            $model->password = null;
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        $session = \Yii::$app->session;
        if ($session->has('my_hr_user')) {
            $session->remove('my_hr_user');
        }

        return $this->redirect(['login']);
    }

    public function actionChangePassword($nik)
    {
        $this->layout = "adminty\my-hr-login";
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }

        $model = new \yii\base\DynamicModel([
            'username', 'password1', 'password2'
        ]);
        $model->addRule(['username', 'password1', 'password2'], 'required');

        $model->username = $nik;

        if($model->load(\Yii::$app->request->post())){
            if ($model->password1 != $model->password2) {
                \Yii::$app->getSession()->setFlash('error', 'Password 1 and Password 2 is different...');
                return $this->render('change-password', [
                    'model' => $model,
                ]);
            } else {
                $model_karyawan = Karyawan::find()
                ->where([
                    'NIK' => $model->username
                ])
                ->one();

                $model_karyawan->PASSWORD = $model->password1;

                if ($model_karyawan->save()) {
                    return $this->redirect(['index']);
                }

            }
        }

        return $this->render('change-password', [
            'model' => $model,
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

    public function actionGetDisiplinDetail($nik, $period, $note = 'DISIPLIN')
    {
        if ($note == 'DISIPLIN') {
            $abensi_data_arr = AbsensiTbl::find()->where([
                'NIK' => $nik,
                'PERIOD' => $period,
                'DISIPLIN' => 0
            ])
            ->orderBy('DATE')
            ->all();
        } else {
            $abensi_data_arr = AbsensiTbl::find()->where([
                'NIK' => $nik,
                'PERIOD' => $period,
                'NOTE' => $note
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
                <td style="text-align: center;">' . date('d M\' Y', strtotime($value['DATE'])) . '</td>
                <td>' . $value['CATEGORY'] . '</td>
            </tr>
            ';
        }
        $data .= '</tbody>';
        $data .= '</table>';
        return $data;
    }
}