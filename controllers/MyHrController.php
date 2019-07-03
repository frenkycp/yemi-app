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
use app\models\search\HrFacilitySearch;
use app\models\HrComplaint;
use app\models\HrFacility;
use dmstr\bootstrap\Tabs;
use app\models\ImageFile;
use yii\web\UploadedFile;

class MyHrController extends Controller
{
    /**
    * @var boolean whether to enable CSRF validation for the actions in this controller.
    * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
    */
    public $enableCsrfValidation = false;

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

    public function actionIndexFacility()
    {
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['my_hr_user'];
        $this->layout = 'my-hr';

        $searchModel  = new HrFacilitySearch;
        $searchModel->nik = $nik;
        $dataProvider = $searchModel->search($_GET);
        return $this->render('index-facility', [
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

    public function actionCreateFacility()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['my_hr_user'];
        $this->layout = 'my-hr';
        $model = new HrFacility;
        $model->scenario = HrFacility::SCENARIO_CREATE;

        try {
            if ($model->load($_POST)) {
                $karyawan = Karyawan::find()
                ->where(['NIK' => $nik])
                ->one();

                $model->nik = '' . $nik;
                $model->emp_name = $karyawan->NAMA_KARYAWAN;
                $model->cc_id = $karyawan->CC_ID;
                $model->dept = $karyawan->DEPARTEMEN;
                $model->section = $karyawan->SECTION;
                $model->sub_section = $karyawan->SUB_SECTION;
                $model->period = date('Ym');
                $model->input_datetime = date('Y-m-d H:i:s');

                $model->img_01 = UploadedFile::getInstance($model, 'img_01');
                if ($model->validate()) {
                    if ($model->img_01) {
                        $new_filename1 = 'MY_FACILITY_' . $nik . '_' . date('Ymd_His') . '.' . $model->img_01->extension;
                        $model->img_filename = $new_filename1;
                        $filePath = \Yii::getAlias("@app/web/uploads/MY FACILITY/") . $new_filename1;
                        if (!$model->img_01->saveAs($filePath)) {
                            return $model->errors;
                        }
                        ImageFile::resize_crop_image($filePath, $filePath, 80, 800);
                    }
                }
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

        return $this->render('create-facility', ['model' => $model]);
    }

    public function actionUploadFacilityImg($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['my_hr_user'];
        $model = HrFacility::find()->where(['id' => $id])->one();

        if ($model->load($_POST)) {
            $model->img_01 = UploadedFile::getInstance($model, 'img_01');
            if ($model->validate()) {
                if ($model->img_01) {
                    $new_filename1 = 'MY_FACILITY_' . $nik . '_' . date('Ymd_His') . '.' . $model->img_01->extension;
                    $model->img_filename = $new_filename1;
                    $filePath = \Yii::getAlias("@app/web/uploads/MY FACILITY/") . $new_filename1;
                    if (!$model->img_01->saveAs($filePath)) {
                        return $model->errors;
                    }
                    ImageFile::resize_crop_image($filePath, $filePath, 80, 800);
                }
            }
            if ($model->save()) {
                return $this->redirect(Url::previous());
            }
        } else {
            return $this->renderAjax('upload-facility-img', [
                'model' => $model,
            ]);
        }
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

	public function actionGetLemburDetail($nik, $nama_karyawan, $period)
    {
        $spl_data_arr = SplView::find()
        ->where([
            'NIK' => $nik,
            'PERIOD' => $period
        ])
        ->orderBy('TGL_LEMBUR')
        ->all();

        $data = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $nik . ' - ' . $nama_karyawan . ' <small>(' . $period . ')</small></h3>
        </div>
        <div class="modal-body">
        ';

        $data .= '<table class="table table-bordered table-striped table-hover">';
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

    public function actionGetDisiplinDetail($nik, $nama_karyawan, $period, $note = 'DISIPLIN')
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
            if ($note == 'CK') {
                $abensi_data_arr = AbsensiTbl::find()->where([
                    'NIK' => $nik,
                    'PERIOD' => $period,
                    'NOTE' => ['CK', 'CK1', 'CK3', 'CK5', 'CK7', 'CK10', 'CK11']
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
            
        }
        
        $data = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $nik . ' - ' . $nama_karyawan . ' <small>(' . $period . ')</small></h3>
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