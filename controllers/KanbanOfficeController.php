<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use yii\web\Controller;
use app\models\Karyawan;
use app\models\KanbanHdr;
use app\models\KanbanDtr;
use app\models\search\KanbanDataSearch;

class KanbanOfficeController extends Controller
{
	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('kanban_office_user')) {
            return $this->redirect(['index']);
        }
        $this->layout = "kanban-office\login";

        $model = new \yii\base\DynamicModel([
            'username', 'password'
        ]);
        $model->addRule(['username', 'password'], 'required');

        if($model->load(\Yii::$app->request->post())){
            $karyawan = Karyawan::find()
            ->where([
                'NIK' => $model->username,
                //'PASSWORD' => $model->password,
            ])
            ->orWhere([
                'NIK_SUN_FISH' => $model->username,
                //'PASSWORD' => $model->password,
            ])
            ->one();
            if ($karyawan->NIK_SUN_FISH == null) {
                \Yii::$app->getSession()->setFlash('warning', 'New NIK format is not set. Please request to HR.');
            } else {
                if ($model->password == $karyawan->PASSWORD) {
                    $session['kanban_office_user'] = $karyawan->NIK_SUN_FISH;
                    $session['kanban_office_name'] = $karyawan->NAMA_KARYAWAN;
                    return $this->redirect(['index']);
                } else {
                    \Yii::$app->getSession()->setFlash('error', 'Incorrect username or password...');
                }
            }
            
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        $session = \Yii::$app->session;
        if ($session->has('kanban_office_user')) {
            $session->remove('kanban_office_user');
            $session->remove('kanban_office_name');
        }

        return $this->redirect(['login']);
    }
    
	public function actionIndex($value='')
	{
		$session = \Yii::$app->session;
        if (!$session->has('kanban_office_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['kanban_office_user'];

        $total_request = KanbanHdr::find()
        ->where([
            'job_stage' => 1
        ])
        ->count();
        $total_progress = KanbanHdr::find()
        ->where([
            'job_stage' => 2
        ])
        ->count();

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

		$this->layout = 'kanban-office\main';
		return $this->render('index', [
            'total_request' => $total_request,
            'total_progress' => $total_progress,
            'nik' => $nik
        ]);
	}

    public function actionData()
    {
        $session = \Yii::$app->session;
        if (!$session->has('kanban_office_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['kanban_office_user'];
        $this->layout = 'kanban-office\main';

        $searchModel  = new KanbanDataSearch;

        if(\Yii::$app->request->get('job_stage') !== null)
        {
            $searchModel->job_stage = \Yii::$app->request->get('job_stage');
        }

        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('data', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionEmpInfo($nik)
    {
        $emp = Karyawan::findOne(['NIK_SUN_FISH' => $nik]);
        $data = [
            'name' => $emp->NAMA_KARYAWAN,
            'dept' => $emp->DEPARTEMEN,
            'section' => $emp->SECTION
        ];
        return $emp->NAMA_KARYAWAN . '||' . $emp->DEPARTEMEN . '||' . $emp->SECTION . '||' . $emp->STATUS_KARYAWAN . '||' . $emp->CC_ID;
    }

    public function actionCreate($value='')
    {
        $session = \Yii::$app->session;
        if (!$session->has('kanban_office_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['kanban_office_user'];
        $name = $session['kanban_office_name'];
        $this->layout = 'kanban-office\main';

        $model = new KanbanHdr();
        date_default_timezone_set('Asia/Jakarta');

        if($model->load(\Yii::$app->request->post())){
            $model->job_issued_nik = $nik;
            $model->job_type = 'REQUEST';
            $model->job_issued_nik_name = $name;

            $sql = "{CALL KANBAN_JOB_CREATE(:job_desc, :job_source, :job_priority, :job_type, :job_issued_nik, :job_issued_nik_name, :request_date, :request_to_nik, :request_to_nik_name, :job_flow_id)}";
            $params = [
                ':job_desc' => $model->job_desc,
                ':job_source' => $model->job_source,
                ':job_priority' => $model->job_priority,
                ':job_type' => $model->job_type,
                ':job_issued_nik' => $model->job_issued_nik,
                ':job_issued_nik_name' => $model->job_issued_nik_name,
                ':request_date' => $model->request_date,
                ':request_to_nik' => $model->request_to_nik,
                ':request_to_nik_name' => $model->request_to_nik_name,
                ':job_flow_id' => $model->job_flow_id,
            ];

            try {
                $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
                //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
            } catch (Exception $ex) {
                \Yii::$app->session->setFlash('danger', "Error : $ex");
            }

            return $this->redirect(Url::previous());
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionGetDailyKanban($nik)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $tmp_kanban = KanbanHdr::find()
        ->where([
            'confirm_to_nik' => $nik,
            'job_stage' => 2
        ])
        ->all();

        $data = [];
        foreach ($tmp_kanban as $key => $value) {
            $data[] = [
                'title' => strtoupper($value->job_desc) . ' [' . $value->job_dtr_step_close . '/' . $value->job_dtr_step_total . ']',
                'start' => (strtotime($value->confirm_schedule_date . " +7 hours") * 1000),
                'allDay' => true,
                'url' => Url::to(['completion', 'job_hdr_no' => $value->job_hdr_no]),
                //'color' => '#00a65a' //green
                'color' => '#f39c12' //orange
            ];
        }

        return json_encode($data);
    }

    public function actionCompletion($job_hdr_no)
    {
        $session = \Yii::$app->session;
        if (!$session->has('kanban_office_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['kanban_office_user'];
        $name = $session['kanban_office_name'];
        $this->layout = 'kanban-office\main';

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        $header = KanbanHdr::find()->where(['job_hdr_no' => $job_hdr_no])->one();
        $detail = KanbanDtr::find()->where(['job_hdr_no' => $job_hdr_no])->orderBy('job_dtr_no')->all();
        return $this->render('completion', [
            'header' => $header,
            'detail' => $detail,
        ]);
    }

    public function actionFinishJob($job_dtr_seq, $status)
    {
        $session = \Yii::$app->session;
        if (!$session->has('kanban_office_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['kanban_office_user'];
        $name = $session['kanban_office_name'];
        $this->layout = 'kanban-office\main';

        date_default_timezone_set('Asia/Jakarta');
        $model = KanbanDtr::find()->where(['job_dtr_seq' => $job_dtr_seq])->one();
        $model->job_dtr_close_reason = null;

        if ($model->load(\Yii::$app->request->post())) {
            $sql = "{CALL KANBAN_JOB_CLOSE_NORMAL(:job_hdr_no, :job_dtr_no, :job_dtr_close_open, :job_dtr_close_reason, :job_dtr_close_open_user_id)}";
            $params = [
                ':job_hdr_no' => $model->job_hdr_no,
                ':job_dtr_no' => $model->job_dtr_no,
                ':job_dtr_close_open' => $status,
                ':job_dtr_close_reason' => $model->job_dtr_close_reason,
                ':job_dtr_close_open_user_id' => $nik
            ];

            try {
                $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
                //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
            } catch (Exception $ex) {
                \Yii::$app->session->setFlash('danger', "Error : $ex");
            }

            return $this->redirect(Url::previous());
        }

        return $this->renderAjax('finish-job', [
            'model' => $model
        ]);
    }

    public function actionConfirmJob($job_hdr_no)
    {
        $session = \Yii::$app->session;
        if (!$session->has('kanban_office_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['kanban_office_user'];
        $name = $session['kanban_office_name'];
        $this->layout = 'kanban-office\main';
        $model = KanbanHdr::find()->where(['job_hdr_no' => $job_hdr_no])->one();
        $model->request_date = date('Y-m-d', strtotime($model->request_date));
        date_default_timezone_set('Asia/Jakarta');

        $input_model = new \yii\base\DynamicModel([
            'confirm_schedule_date'
        ]);
        $input_model->addRule(['confirm_schedule_date'], 'required');

        if ($input_model->load(\Yii::$app->request->post())) {
            //return $job_hdr_no . ', ' . $input_model->confirm_schedule_date . ' - ' . $nik;
            $sql = "{CALL KANBAN_JOB_CONFIRM(:job_hdr_no, :confirm_date, :confirm_to_nik)}";
            $params = [
                ':job_hdr_no' => $job_hdr_no,
                ':confirm_date' => $input_model->confirm_schedule_date,
                ':confirm_to_nik' => $nik
            ];

            try {
                $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
                //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
            } catch (Exception $ex) {
                \Yii::$app->session->setFlash('danger', "Error : $ex");
            }
            return $this->redirect(Url::previous());
        }

        return $this->renderAjax('confirm-job', [
            'model' => $model,
            'input_model' => $input_model
        ]);
    }
}
