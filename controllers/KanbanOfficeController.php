<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use yii\web\Controller;
use app\models\Karyawan;
use app\models\KanbanHdr;
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
            
            //$model->username = null;
            //$model->password = null;
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

		$this->layout = 'kanban-office\main';
		return $this->render('index', [
            'total_request' => $total_request,
            'total_progress' => $total_progress,
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
}
