<?php
namespace app\controllers;

use app\models\search\MrbsEntrySearch;
use app\models\ProdAttendanceData;
use app\models\ProdAttendanceLog;
use app\models\Karyawan;
use app\models\WipLocation;
use yii\web\Controller;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

class ProdAttendanceController extends Controller
{
	public function actionIndex($loc = '', $line = '')
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $posting_shift = date('Y-m-d');
        $model = new \yii\base\DynamicModel([
            'child_analyst', 'line', 'child_analyst_desc', 'nik'
        ]);
        $model->addRule(['child_analyst_desc', 'nik'], 'string')
        ->addRule(['line', 'child_analyst'], 'required');

        $model->child_analyst = $loc;
        $model->line = $line;

        if($model->load(\Yii::$app->request->post())){
            $find_data = ProdAttendanceData::find()
            ->where([
                'nik' => $model->nik,
                'child_analyst' => $model->child_analyst,
                'line' => $model->line,
                'posting_shift' => $posting_shift
            ])
            ->one();
            $now = date('Y-m-d H:i:s');

            if ($find_data->nik == null) {
                $insert_attendance = new ProdAttendanceData;
                $insert_attendance->period = date('Ym', strtotime($posting_shift));
                $insert_attendance->posting_date = date('Y-m-d');
                $insert_attendance->posting_shift = $posting_shift;
                $insert_attendance->att_data_id = $model->child_analyst . '-' . $model->line . '-' . date('Ymd', strtotime($posting_shift)) . '-' . $model->nik;
                $insert_attendance->nik = $model->nik;

                $karyawan = Karyawan::find()
                ->select('NAMA_KARYAWAN')
                ->where([
                    'NIK' => $model->nik
                ])
                ->one();
                $insert_attendance->name = $karyawan->NAMA_KARYAWAN;
                $insert_attendance->check_in = $now;
                $insert_attendance->child_analyst = $model->child_analyst;

                $location_data = WipLocation::find()
                ->where([
                    'child_analyst' => $model->child_analyst
                ])
                ->one();
                $insert_attendance->child_analyst_desc = $location_data->child_analyst_desc;
                $insert_attendance->current_status = 'I';
            } else {
            	$insert_attendance = $find_data;
                $insert_attendance->check_out = $now;
                if ($insert_attendance->current_status == 'I') {
                	$insert_attendance->current_status = 'O';
                } else {
                	$insert_attendance->current_status = 'I';
                }
            }
            $insert_attendance->line = $model->line;
            $insert_attendance->last_update = $now;

            if ($insert_attendance->save()) {
                $find_log = ProdAttendanceLog::find()
                ->where(['att_data_id' => $insert_attendance->att_data_id])
                ->orderBy('last_update DESC')
                ->one();

                if ($find_log->att_log_id == null) {
                    $find_log = new ProdAttendanceLog;
                    $find_log->att_type = 'I';
                } else {
                    if ($find_log->att_type == 'I') {
                        $find_log->att_type = 'O';
                    }
                }
                $find_log->att_data_id = $insert_attendance->att_data_id;
                $find_log->last_update = $now;
                if (!$find_log->save()) {
                    return json_encode($find_log->errors);
                }
            } else {
                return json_encode($insert_attendance->errors);
            }
            $model->nik = null;
        }

        $attendance_data = ProdAttendanceData::find()
        ->where([
            'child_analyst' => $model->child_analyst,
            'line' => $model->line,
            'posting_shift' => $posting_shift
        ])
        ->orderBy('last_update DESC')
        ->all();

        return $this->render('index', [
            'model' => $model,
            'attendance_data' => $attendance_data,
        ]);
	}
}