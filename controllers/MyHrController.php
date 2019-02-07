<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Karyawan;
use app\models\RekapAbsensiView;
use app\models\CutiRekapView02;
use app\models\SplView;
use app\models\AbsensiTbl;
use app\models\HrLoginLog;
use yii\helpers\Url;
use app\models\search\HrComplaintSearch;
use app\models\HrComplaint;
use dmstr\bootstrap\Tabs;

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
        $this_year = date('Y');
        if (\Yii::$app->request->get('year') != null) {
            $this_year = \Yii::$app->request->get('year');
        }
		//$nik = \Yii::$app->request->get('nik');
        $nik = $session['my_hr_user'];

        $model_karyawan = Karyawan::find()->where([
            'NIK' => $nik
        ])->one();

        /*$model_rekap_absensi = RekapAbsensiView::find()->where([
            'NIK' => $nik,
            'YEAR' => $this_year
        ])
        ->orderBy('PERIOD')
        ->all(); */

        $absensi_data = AbsensiTbl::find()
        ->select([
            'PERIOD',
            'NIK',
            'NAMA_KARYAWAN',
            'ALPHA' => 'SUM(CASE WHEN NOTE = \'A\' THEN 1 ELSE 0 END)',
            'IJIN' => 'SUM(CASE WHEN NOTE = \'I\' THEN 1 ELSE 0 END)',
            'SAKIT' => 'SUM(CASE WHEN NOTE = \'S\' THEN 1 ELSE 0 END)',
            'CUTI' => 'SUM(CASE WHEN NOTE = \'C\' THEN 1 ELSE 0 END)',
            'CUTI_KHUSUS' => 'SUM(CASE WHEN NOTE IN (\'CK\', \'CK1\', \'CK3\', \'CK5\', \'CK7\', \'CK10\', \'CK11\') THEN 1 ELSE 0 END)',
            'NO_DISIPLIN' => 'SUM(CASE WHEN DISIPLIN = 0 AND CATEGORY != \'WAIT\' THEN 1 ELSE 0 END)',
            'DATANG_TERLAMBAT' => 'SUM(CASE WHEN NOTE = \'DL\' THEN 1 ELSE 0 END)',
            'PULANG_CEPAT' => 'SUM(CASE WHEN NOTE = \'PC\' THEN 1 ELSE 0 END)',
            'SHIFT1' => 'SUM(CASE WHEN SHIFT = \'I\' THEN 1 ELSE 0 END)',
            'SHIFT2' => 'SUM(CASE WHEN SHIFT = \'II\' THEN 1 ELSE 0 END)',
            'SHIFT3' => 'SUM(CASE WHEN SHIFT = \'III\' THEN 1 ELSE 0 END)',
            'SHIFT4' => 'SUM(CASE WHEN SHIFT = \'IV.1\' THEN 1 WHEN SHIFT = \'IV.2\' THEN 1 WHEN SHIFT = \'IV.3\' THEN 1 ELSE 0 END)'
        ])
        ->where([
            'NIK' => $nik,
            'YEAR' => $this_year
        ])
        ->groupBy('PERIOD, NIK, NAMA_KARYAWAN')
        ->orderBy('PERIOD')
        ->all();

        $rekap_cuti_arr = CutiRekapView02::find()
        ->where([
            'TAHUN' => $this_year,
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
            'absensi_data' => $absensi_data,
			'model_karyawan' => $model_karyawan,
            //'model_rekap_absensi' => $model_rekap_absensi,
            'using_cuti' => $using_cuti,
            'kuota_cuti' => $kuota_cuti,
            'sisa_cuti' => $sisa_cuti,
            'year' => $this_year,
		]);
	}

    /**
    * Lists all HrComplaint models.
    * @return mixed
    */
    public function actionIndexLaporan()
    {
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['my_hr_user'];
        $this->layout = 'my-hr';
        $searchModel  = new HrComplaintSearch;
        $searchModel->nik = $nik;
        $searchModel->category = $_GET['category'];
        $_GET['hr_sort'] = 'hr_sort';
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('index-laporan', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
    * Creates a new HrComplaint model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreateLaporan()
    {
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['my_hr_user'];
        $this->layout = 'my-hr';
        date_default_timezone_set('Asia/Jakarta');
        $model = new HrComplaint;
        $model->category = $_GET['category'];

        try {
            if ($model->load($_POST)) {
                $karyawan = Karyawan::find()
                ->where(['NIK' => $nik])
                ->one();

                $model->nik = '' . $nik;
                $model->emp_name = $karyawan->NAMA_KARYAWAN;
                $model->department = $karyawan->DEPARTEMEN;
                $model->section = $karyawan->SECTION;
                $model->sub_section = $karyawan->SUB_SECTION;
                $model->period = date('Ym');
                $model->input_datetime = date('Y-m-d H:i:s');
                //$model->category = 'HR';
                if ($model->save()) {
                    return $this->redirect(Url::previous());
                }
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }
        return $this->render('create-laporan', ['model' => $model]);
    }

    public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
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
                $session['my_hr_name'] = $karyawan->NAMA_KARYAWAN;
                $hr_log = HrLoginLog::find()->where([
                    'nik' => $karyawan->NIK,
                    'login_date' => date('Y-m-d')
                ])->one();
                if ($hr_log->nik === null) {
                    $hr_log = new HrLoginLog();
                    $hr_log->id = date('Ymd') . $karyawan->NIK;
                    $hr_log->nik = $karyawan->NIK;
                    $hr_log->emp_name = $karyawan->NAMA_KARYAWAN;
                    $hr_log->period = date('Ym');
                    $hr_log->department = $karyawan->DEPARTEMEN;
                    $hr_log->section = $karyawan->SECTION;
                    $hr_log->sub_section = $karyawan->SUB_SECTION;
                    $hr_log->login_date = date('Y-m-d');
                    $hr_log->login_count = 0;
                }
                $hr_log->login_count++;
                $hr_log->last_login = date('Y-m-d H:i:s');
                $hr_log->save();

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
            <th style="text-align: center;">SPL Num.</th>
            <th style="text-align: center;">Workday/Holiday</th>
            <th style="text-align: center;">Date</th>
            <th style="text-align: center;">Overtime Plan</th>
            <th style="text-align: center;">Overtime Actual</th>
            <th>Reason</th>
        </tr></thead>'
        ;
        $data .= '<tbody>';
        foreach ($spl_data_arr as $key => $value) {
            $hari_kerja = $value->JENIS_LEMBUR == 'HARI KERJA' ? 'WORKDAY' : 'HOLIDAY';
            $data .= '
            <tr>
                <td style="text-align: center;">' . $value->SPL_HDR_ID . '</td>
                <td style="text-align: center;">' . $hari_kerja . '</td>
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
            <th style="text-align: center;">Date</th>
            <th>Description</th>
        </tr></thead>'
        ;
        $data .= '<tbody>';
        foreach ($abensi_data_arr as $key => $value) {
            $keterangan = '-';
            if ($value['CATEGORY'] == 'SAKIT') {
                $keterangan = 'SICK';
            } elseif ($value['CATEGORY'] == 'IJIN') {
                $keterangan = 'PERMIT';
            } elseif ($value['CATEGORY'] == 'ALPHA') {
                $keterangan = 'ABSENT';
            } elseif ($value['CATEGORY'] == 'CUTI') {
                $keterangan = 'ON LEAVE';
            }
            $data .= '
            <tr>
                <td style="text-align: center;">' . date('d M\' Y', strtotime($value['DATE'])) . '</td>
                <td>' . $keterangan . '</td>
            </tr>
            ';
        }
        $data .= '</tbody>';
        $data .= '</table>';
        return $data;
    }
}