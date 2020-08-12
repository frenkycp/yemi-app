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
use yii\web\JsExpression;
use app\models\SunfishEmpAttendance;
use app\models\SunfishLeaveSummary;
use app\models\SunfishViewEmp;

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

        $section = $model_karyawan->SECTION;
        $data_attendance_arr = [];

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
            'CUTI_KHUSUS' => 'SUM(CASE WHEN PATINDEX(\'%CK%\', NOTE) > 0 THEN 1 ELSE 0 END)',
            'CUTI_KHUSUS_ND' => 'SUM(CASE WHEN NOTE IN (\'CK9\', \'CK10\', \'CK11\') THEN 1 ELSE 0 END)',
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
        ->andWhere(['<', 'PERIOD', '202003'])
        ->groupBy('PERIOD, NIK, NAMA_KARYAWAN')
        ->orderBy('PERIOD')
        ->all();

        foreach ($absensi_data as $key => $value) {
            $data_attendance_arr[$value['PERIOD']] = [
                'emp_no' => $value->NIK,
                'period' => $value->PERIOD,
                'source' => 1,
                'total_absent' => $value->ALPHA,
                'total_present' => 0,
                'total_permit' => $value->IJIN,
                'total_sick' => $value->SAKIT,
                'total_late' => $value->DATANG_TERLAMBAT,
                'total_early_out' => $value->PULANG_CEPAT,
                'total_shift2' => $value->SHIFT2,
                'total_shift3' => $value->SHIFT3,
                'total_shift4' => $value->SHIFT4,
                'total_cuti' => $value->CUTI,
                'total_ck' => $value->CUTI_KHUSUS,
                'total_ck_no_disiplin' => $value->CUTI_KHUSUS_ND,
            ];
        }

        $absensi_data_sunfish = SunfishEmpAttendance::find()
        ->select([
            'emp_no',
            'period' => 'FORMAT(shiftstarttime, \'yyyyMM\')',
            'total_work_days' => 'COUNT(emp_id)',
            'total_absent' => 'SUM(CASE WHEN PATINDEX(\'%ABS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'total_present' => 'SUM(CASE WHEN PATINDEX(\'%PRS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'total_permit' => 'SUM(CASE WHEN (PATINDEX(\'%Izin%\', Attend_Code) > 0 OR PATINDEX(\'%IPU%\', Attend_Code) > 0) AND PATINDEX(\'%PRS%\', Attend_Code) = 0 THEN 1 ELSE 0 END)',
            'total_sick' => 'SUM(CASE WHEN PATINDEX(\'%SAKIT%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0 THEN 1 ELSE 0 END)',
            'total_cuti' => 'SUM(CASE WHEN PATINDEX(\'%CUTI%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0 AND PATINDEX(\'%Izin%\', Attend_Code) = 0 THEN 1 ELSE 0 END)',
            'total_late' => 'SUM(CASE WHEN PATINDEX(\'%LTI%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'total_early_out' => 'SUM(CASE WHEN PATINDEX(\'%EAO%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'total_shift2' => 'SUM(CASE WHEN (PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 OR PATINDEX(\'%MAINTENANCE%\', UPPER(shiftdaily_code)) > 0) AND PATINDEX(\'%PRS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'total_shift3' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'total_shift4' => 'SUM(CASE WHEN PATINDEX(\'%4G_SHIFT%\', UPPER(shiftdaily_code)) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'total_ck' => 'SUM(CASE WHEN (PATINDEX(\'%CK%\', Attend_Code) > 0 OR PATINDEX(\'%UPL%\', Attend_Code) > 0) AND PATINDEX(\'%PRS%\', Attend_Code) = 0 AND PATINDEX(\'%Izin%\', Attend_Code) = 0 THEN 1 ELSE 0 END)',
            'total_ck_no_disiplin' => 'SUM(CASE WHEN Attend_Code IN (\'CK9\', \'CK10\', \'CK11\') AND PATINDEX(\'%Izin%\', Attend_Code) = 0 THEN 1 ELSE 0 END)',
        ])
        ->where([
            'FORMAT(shiftstarttime, \'yyyy\')' => $this_year,
            'emp_no' => $model_karyawan->NIK_SUN_FISH,
        ])
        ->andWhere(['<>', 'shiftdaily_code', 'OFF'])
        ->andWhere(['>=', 'FORMAT(shiftstarttime, \'yyyyMM\')', '202003'])
        ->groupBy(['emp_no', 'FORMAT(shiftstarttime, \'yyyyMM\')'])
        ->orderBy('period')
        ->all();

        foreach ($absensi_data_sunfish as $key => $value) {
            $data_attendance_arr[$value['period']] = [
                'emp_no' => $value->emp_no,
                'period' => $value->period,
                'source' => 2,
                'total_absent' => $value->total_absent,
                'total_present' => $value->total_present,
                'total_permit' => $value->total_permit,
                'total_sick' => $value->total_sick,
                'total_late' => $value->total_late,
                'total_early_out' => $value->total_early_out,
                'total_shift2' => $value->total_shift2,
                'total_shift3' => $value->total_shift3,
                'total_shift4' => $value->total_shift4,
                'total_cuti' => $value->total_cuti,
                'total_ck' => $value->total_ck,
                'total_ck_no_disiplin' => $value->total_ck_no_disiplin,
            ];
        }

        /*$rekap_cuti_arr = CutiRekapView02::find()
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
        }*/

        $cuti_summary = SunfishLeaveSummary::find()
        ->where([
            'emp_no' => $model_karyawan->NIK_SUN_FISH,
            'leave_code' => 'ANL'
        ])
        ->andWHere([
            'FORMAT(startvaliddate, \'yyyy\')' => $this_year
        ])
        ->one();
        $sisa_cuti = (int)$cuti_summary->remaining;
        $kuota_cuti = (int)$cuti_summary->entitlement;

        $cuti_panjang_summary = SunfishLeaveSummary::find()
        ->where([
            'emp_no' => $model_karyawan->NIK_SUN_FISH,
            'active_status' => 1
            //'leave_code' => 'LONGN2YEMI',
            //'FORMAT(endvaliddate, \'yyyy\')' => $this_year
        ])
        ->andWhere('PATINDEX(\'%LONG%\', leave_code) > 0')
        ->andWHere([
            'FORMAT(startvaliddate, \'yyyy\')' => $this_year
        ])
        ->one();
        $sisa_cuti_panjang = (int)$cuti_panjang_summary->remaining;
        $kuota_cuti_panjang = (int)$cuti_panjang_summary->entitlement;

        $from_date = date('Y-m-01', strtotime(date('Y-m-d') . '-1 year'));
        $to_date = date('Y-m-t', strtotime(date('Y-m-d')));
        // $tmp_categories = SplView::find()
        // ->select('PERIOD')
        // ->where(['>=', 'PERIOD', date('Ym', strtotime($from_date))])
        // ->andWhere(['<=', 'PERIOD', date('Ym', strtotime($to_date))])
        // ->groupBy('PERIOD')
        // ->all();
        
        // foreach ($tmp_categories as $key => $value) {
        //     $categories[] = $value->PERIOD;
        // }

        // $karyawan_arr = SplView::find()
        // ->select([
        //     'NIK', 'NAMA_KARYAWAN', 'CC_ID', 'CC_DESC'
        // ])
        // ->where([
        //     'CC_ID' => $model_karyawan->CC_ID,
        //     'PERIOD' => $categories,
        //     //'NIK' => $model_karyawan->NIK,
        // ])
        // ->andWhere('NIK IS NOT NULL')
        // ->groupBy('NIK, NAMA_KARYAWAN, CC_ID, CC_DESC')
        // ->asArray()
        // ->all();

        // $overtime_data = SplView::find()
        // ->select([
        //     'PERIOD',
        //     'NIK',
        //     'NAMA_KARYAWAN',
        //     'CC_ID',
        //     'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
        // ])
        // ->where([
        //     'PERIOD' => $categories,
        //     //'NIK' => $model_karyawan->NIK,
        //     'CC_ID' => $model_karyawan->CC_ID
        // ])
        // ->groupBy('PERIOD, NIK, NAMA_KARYAWAN, CC_ID')
        // ->orderBy('NIK, PERIOD')
        // ->asArray()
        // ->all();

        // $data = [];
        // foreach ($karyawan_arr as $karyawan) {
        //     $tmp_data = [];
        //     foreach ($categories as $period_value) {
        //         $hour = 0;
        //         foreach ($overtime_data as $value) {
        //             if ($value['NIK'] == $karyawan['NIK'] && $period_value == $value['PERIOD']) {
        //                 $hour = $value['NILAI_LEMBUR_ACTUAL'];
        //                 continue;
        //             }
        //         }
        //         $tmp_data[] = [
        //             'y' => round($hour, 2),
        //             'url' => Url::to(['get-remark', 'nik' => $karyawan['NIK'], 'nama_karyawan' => $karyawan['NAMA_KARYAWAN'], 'period' => $period_value])
        //         ];
        //     }
        //     $data[] = [
        //         'name' => $karyawan['NIK'] . ' - ' . $karyawan['NAMA_KARYAWAN'] . ' (' . $karyawan['CC_DESC'] . ')',
        //         'data' => $tmp_data,
        //         'showInLegend' => false,
        //         'lineWidth' => 0.9,
        //         'color' => new JsExpression('Highcharts.getOptions().colors[0]')
        //     ];
        // }

        $model_karyawan_sunfish = SunfishViewEmp::find()->where(['Emp_no' => $model_karyawan->NIK_SUN_FISH])->one();

		return $this->render('index', [
            'absensi_data' => $absensi_data,
            'absensi_data_sunfish' => $absensi_data_sunfish,
			'model_karyawan' => $model_karyawan,
            'model_karyawan_sunfish' => $model_karyawan_sunfish,
            //'model_rekap_absensi' => $model_rekap_absensi,
            'using_cuti' => $using_cuti,
            'kuota_cuti' => $kuota_cuti,
            'sisa_cuti' => $sisa_cuti,
            'using_cuti_panjang' => $using_cuti_panjang,
            'kuota_cuti_panjang' => $kuota_cuti_panjang,
            'sisa_cuti_panjang' => $sisa_cuti_panjang,
            'year' => $this_year,
            'section' => $section,
            'categories' => $categories,
            'data' => $data,
            'data_attendance_arr' => $data_attendance_arr,
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
        $nik_sunfish = $session['my_hr_user_sunfish'];
        $this->layout = 'my-hr';
        $searchModel  = new HrComplaintSearch;
        $searchModel->nik = [$nik, $nik_sunfish];
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

    public function actionIndexBpjs()
    {
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['my_hr_user'];
        $nik_sunfish = $session['my_hr_user_sunfish'];
        $this->layout = 'my-hr';
        $searchModel  = new HrComplaintSearch;
        $searchModel->nik = [$nik, $nik_sunfish];
        $searchModel->category = 'BPJS';
        $_GET['hr_sort'] = 'hr_sort';
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('index-bpjs', [
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
        $nik_sunfish = $session['my_hr_user_sunfish'];
        $this->layout = 'my-hr';

        $searchModel  = new HrFacilitySearch;
        $searchModel->nik = [$nik, $nik_sunfish];
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
        $nik_sunfish = $session['my_hr_user_sunfish'];
        $this->layout = 'my-hr';
        date_default_timezone_set('Asia/Jakarta');
        $model = new HrComplaint;
        $model->category = $_GET['category'];

        try {
            if ($model->load($_POST)) {
                $karyawan = Karyawan::find()
                ->where(['NIK' => $nik])
                ->one();

                $model->nik = '' . $nik_sunfish;
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

    public function actionCreateBpjs()
    {
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['my_hr_user'];
        $nik_sunfish = $session['my_hr_user_sunfish'];
        $this->layout = 'my-hr';
        date_default_timezone_set('Asia/Jakarta');
        $model = new HrComplaint;

        try {
            if ($model->load($_POST)) {
                $karyawan = Karyawan::find()
                ->where(['NIK' => $nik])
                ->one();

                $model->nik = '' . $nik_sunfish;
                $model->emp_name = $karyawan->NAMA_KARYAWAN;
                $model->department = $karyawan->DEPARTEMEN;
                $model->section = $karyawan->SECTION;
                $model->sub_section = $karyawan->SUB_SECTION;
                $model->period = date('Ym');
                $model->input_datetime = date('Y-m-d H:i:s');
                $model->category = 'BPJS';
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
        return $this->render('create-bpjs', ['model' => $model]);
    }

    public function actionCreateFacility()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if (!$session->has('my_hr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['my_hr_user'];
        $nik_sunfish = $session['my_hr_user_sunfish'];
        $this->layout = 'my-hr';
        $model = new HrFacility;
        $model->scenario = HrFacility::SCENARIO_CREATE;

        try {
            if ($model->load($_POST)) {
                $karyawan = Karyawan::find()
                ->where(['NIK' => $nik])
                ->one();

                $model->nik = '' . $nik_sunfish;
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
                'OR',
                ['NIK' => strtoupper($model->username)],
                ['NIK_SUN_FISH' => strtoupper($model->username)],
            ])
            ->andWhere(['PASSWORD' => $model->password,])
            ->one();
            if ($karyawan->NIK !== null) {
                $session['my_hr_user'] = $karyawan->NIK;
                $session['my_hr_user_sunfish'] = $karyawan->NIK_SUN_FISH;
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
        // $spl_data_arr = SplView::find()
        // ->where([
        //     'NIK' => $nik,
        //     'PERIOD' => $period
        // ])
        // ->orderBy('TGL_LEMBUR')
        // ->all();

        $spl_data_arr = SunfishEmpAttendance::find()
        ->where([
            'emp_no' => $nik,
            'FORMAT(shiftstarttime, \'yyyyMM\')' => $period
        ])
        ->andWhere('total_ot IS NOT NULL')
        ->orderBy('shiftstarttime')
        ->all();

        $data = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $nik . ' - ' . $nama_karyawan . ' <small>(' . $period . ')</small></h3>
        </div>
        <div class="modal-body">
        ';

        $data .= '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<thead>
        <tr>
            <th rowspan="2" class="text-center">SPL Num.</th>
            <th rowspan="2" class="text-center">Workday/Holiday</th>
            <th rowspan="2" class="text-center">Date</th>
            <th colspan="2" class="text-center">Overtime Plan</th>
            <th colspan="2" class="text-center">Overtime Actual</th>
            <th rowspan="2" class="text-center">Total (Hour)</th>
        </tr>
        <tr>
            <th class="text-center">From</th>
            <th class="text-center">To</th>
            <th class="text-center">From</th>
            <th class="text-center">To</th>
        </tr>
        </thead>'
        ;
        $data .= '<tbody>';
        foreach ($spl_data_arr as $key => $value) {
            $hari_kerja = $value->shiftdaily_code == 'OFF' ? 'HOLIDAY' : 'WORKDAY';
            $total_ot = round($value->total_ot / 60, 2);
            $data .= '
            <tr>
                <td class="text-center">' . $value->ovtrequest_no . '</td>
                <td class="text-center">' . $hari_kerja . '</td>
                <td class="text-center">' . date('l, d M\' Y', strtotime($value->shiftstarttime)) . '</td>
                <td class="text-center">' . date('Y-m-d H:i', strtotime($value->ovtplanfrom)) . '</td>
                <td class="text-center">' . date('Y-m-d H:i', strtotime($value->ovtplanto)) . '</td>
                <td class="text-center">' . date('Y-m-d H:i', strtotime($value->ovtactfrom)) . '</td>
                <td class="text-center">' . date('Y-m-d H:i', strtotime($value->ovtactto)) . '</td>
                <td class="text-center">' . $total_ot . '</td>
            </tr>
            ';
        }
        $data .= '</tbody>';
        $data .= '</table>';
        return $data;
    }

    public function getCodeDescription($note = '', $attend_code = '')
    {
        if ($note == 'S') {
            $keterangan = 'SICK';
        } elseif ($note == 'I') {
            $keterangan = 'PERMIT';
        } elseif ($note == 'A') {
            $keterangan = 'ABSENT';
        } elseif ($note == 'C') {
            $keterangan = 'ON LEAVE';
        } elseif ($note == 'DL') {
            $keterangan = 'COME LATE';
        } elseif ($note == 'PC') {
            $keterangan = 'GO HOME EARLY';
        } else {
            $keterangan = '-';
        }
        
        if (strpos($attend_code, 'CK15')) {
            $keterangan = 'Saudara Kandung Menikah';
        } elseif (strpos($attend_code, 'CK13')) {
            $keterangan = 'Musibah';
        } elseif (strpos($attend_code, 'CK12')) {
            $keterangan = 'Ibadah Haji / Ziarah Keagamaan';
        } elseif (strpos($attend_code, 'CK11')) {
            $keterangan = 'Keguguran';
        } elseif (strpos($attend_code, 'CK10')) {
            $keterangan = 'Melahirkan';
        } elseif (strpos($attend_code, 'CK1')) {
            $keterangan = 'Keluarga Meninggal';
        } elseif (strpos($attend_code, 'CK2')) {
            $keterangan = 'Keluarga Serumah Meninggal';
        } elseif (strpos($attend_code, 'CK3')) {
            $keterangan = 'Menikah';
        } elseif (strpos($attend_code, 'CK4')) {
            $keterangan = 'Menikahkan';
        } elseif (strpos($attend_code, 'CK5')) {
            $keterangan = 'Menghitankan';
        } elseif (strpos($attend_code, 'CK6')) {
            $keterangan = 'Membaptiskan';
        } elseif (strpos($attend_code, 'CK7')) {
            $keterangan = 'Istri Keguguran / Melahirkan';
        } elseif (strpos($attend_code, 'CK8')) {
            $keterangan = 'Tugas Negara';
        } elseif (strpos($attend_code, 'CK9')) {
            $keterangan = 'Haid';
        } elseif (strpos($attend_code, 'UPL')) {
            $keterangan = 'Tambahan Cuti Melahirkan';
        }

        return $keterangan;
    }

    public function actionGetDisiplinDetail($nik, $nama_karyawan, $period, $source, $note = 'DISIPLIN')
    {
        /*if ($note == 'DISIPLIN') {
            $abensi_data_arr = AbsensiTbl::find()->where([
                'NIK' => $nik,
                'PERIOD' => $period,
                'DISIPLIN' => 0
            ])
            ->orderBy('DATE')
            ->all();
            $abensi_data_arr = SunfishEmpAttendance::find()
            ->where([
                'emp_no' => $nik,
                'FORMAT(shiftstarttime, \'yyyyMM\')' => $period
            ])
            ->all();
        } else {
            
            if ($note == 'CK') {
                $abensi_data_arr = AbsensiTbl::find()->where([
                    'NIK' => $nik,
                    'PERIOD' => $period,
                    'NOTE' => ['CK', 'CK1', 'CK3', 'CK5', 'CK7', 'CK10', 'CK11', 'CK12']
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
            
        }*/
        $summary_data_arr = [];
        if ($source == 1) {
            if ($note == 'CK') {
                $abensi_data_arr = AbsensiTbl::find()
                ->where([
                    'NIK' => $nik,
                    'PERIOD' => $period,
                ])
                ->andWhere('PATINDEX(\'%CK%\', NOTE) > 0')
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

            foreach ($abensi_data_arr as $key => $value) {
                $keterangan = $this->getCodeDescription($note, $note);

                $summary_data_arr[] = [
                    'starttime' => $value->CHECK_IN,
                    'endtime' => $value->CHECK_OUT,
                    'keterangan' => $keterangan,
                    'shiftstarttime' => date('Y-m-d', strtotime($value->DATE)),
                ];
            }
        } else {
            if ($note == 'A') {
                $abensi_data_arr = SunfishEmpAttendance::find()
                ->where([
                    'emp_no' => $nik,
                    'FORMAT(shiftstarttime, \'yyyyMM\')' => $period
                ])
                ->andWhere('PATINDEX(\'%ABS%\', Attend_Code) > 0')
                ->orderBy('shiftstarttime')
                ->all();
                
            } elseif ($note == 'I') {
                $abensi_data_arr = SunfishEmpAttendance::find()
                ->where([
                    'emp_no' => $nik,
                    'FORMAT(shiftstarttime, \'yyyyMM\')' => $period
                ])
                ->andWhere('(PATINDEX(\'%Izin%\', Attend_Code) > 0 OR PATINDEX(\'%IPU%\', Attend_Code) > 0) AND PATINDEX(\'%PRS%\', Attend_Code) = 0')
                ->orderBy('shiftstarttime')
                ->all();
                
            } elseif ($note == 'S') {
                $abensi_data_arr = SunfishEmpAttendance::find()
                ->where([
                    'emp_no' => $nik,
                    'FORMAT(shiftstarttime, \'yyyyMM\')' => $period
                ])
                ->andWhere('PATINDEX(\'%SAKIT%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0')
                ->orderBy('shiftstarttime')
                ->all();
                
            } elseif ($note == 'DL') {
                $abensi_data_arr = SunfishEmpAttendance::find()
                ->where([
                    'emp_no' => $nik,
                    'FORMAT(shiftstarttime, \'yyyyMM\')' => $period
                ])
                ->andWhere('PATINDEX(\'%LTI%\', Attend_Code) > 0')
                ->orderBy('shiftstarttime')
                ->all();
                
            } elseif ($note == 'PC') {
                $abensi_data_arr = SunfishEmpAttendance::find()
                ->where([
                    'emp_no' => $nik,
                    'FORMAT(shiftstarttime, \'yyyyMM\')' => $period
                ])
                ->andWhere('PATINDEX(\'%EAO%\', Attend_Code) > 0')
                ->orderBy('shiftstarttime')
                ->all();
                
            } elseif ($note == 'C') {
                $abensi_data_arr = SunfishEmpAttendance::find()
                ->where([
                    'emp_no' => $nik,
                    'FORMAT(shiftstarttime, \'yyyyMM\')' => $period
                ])
                ->andWhere('PATINDEX(\'%CUTI%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0')
                ->orderBy('shiftstarttime')
                ->all();
                
            } elseif ($note == 'CK') {
                $abensi_data_arr = SunfishEmpAttendance::find()
                ->where([
                    'emp_no' => $nik,
                    'FORMAT(shiftstarttime, \'yyyyMM\')' => $period
                ])
                ->andWhere('PATINDEX(\'%CK%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0 AND PATINDEX(\'%Izin%\', Attend_Code) = 0')
                ->orderBy('shiftstarttime')
                ->all();
                
            }

            foreach ($abensi_data_arr as $key => $value) {
                $keterangan = $this->getCodeDescription($note, $value->Attend_Code);

                $summary_data_arr[] = [
                    'starttime' => $value->starttime,
                    'endtime' => $value->endtime,
                    'keterangan' => $keterangan,
                    'shiftstarttime' => date('Y-m-d', strtotime($value->shiftstarttime)),
                ];
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
        foreach ($summary_data_arr as $key => $value) {

            // $check_in = $value['starttime'];
            // $check_out = $value['endtime'];

            // if ($check_in > $check_out) {
            //     $tmp = $check_in;
            //     $check_in = $check_out;
            //     $check_out = $tmp;
            // }
            $check_in = $value['starttime'] == null ? '-' : date('H:i:s', strtotime($value['starttime']));
            $check_out = $value['endtime'] == null ? '-' : date('H:i:s', strtotime($value['endtime']));

            

            $data .= '
            <tr>
                <td class="text-center">' . date('d M\' Y', strtotime($value['shiftstarttime'])) . '</td>
                <td class="text-center">' . strtoupper($value['keterangan']) . '</td>
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