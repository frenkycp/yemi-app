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
	public function FunctionName($value='')
	{
		# code...
	}
	public function actionIndex($loc = '', $line = '')
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $posting_shift = date('Y-m-d');

        Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

        $model = new \yii\base\DynamicModel([
            'child_analyst', 'line', 'child_analyst_desc', 'nik', 'shift'
        ]);
        $model->addRule(['child_analyst_desc', 'nik', 'child_analyst'], 'string')
        ->addRule(['line', 'shift'], 'number');

        $model->child_analyst = $loc;
        $model->line = $line;

        if($model->load(\Yii::$app->request->post())){
    		if ($model->child_analyst == '') {
        		\Yii::$app->session->setFlash("danger", "Location must be set ...");
        	} else {
        		$input_nik = strtoupper($model->nik);
        		if ($input_nik != '') {
	        		$karyawan = Karyawan::find()
		            ->select('NIK, NIK_SUN_FISH, NAMA_KARYAWAN')
		            ->where([
		                'OR',
		                ['NIK' => $input_nik],
		                ['NIK_SUN_FISH' => $input_nik]
		            ])
		            ->one();

		            if ($karyawan->NIK != null) {
				        if (date('H:i:s') < '07:00:00' && $model->shift == 3) {
				        	$posting_shift = date('Y-m-d', strtotime(' -1 day'));
				        }
		            	
	            		$find_data = ProdAttendanceData::find()
			            ->where([
			                'nik' => $karyawan->NIK_SUN_FISH,
			                'child_analyst' => $model->child_analyst,
			                'line' => $model->line,
			                'posting_shift' => $posting_shift,
			                'shift' => $model->shift,
			            ])
			            ->one();
			            $now = date('Y-m-d H:i:s');

			            if ($find_data->nik == null) {
			                $insert_attendance = new ProdAttendanceData;
			                $insert_attendance->period = date('Ym', strtotime($posting_shift));
			                $insert_attendance->posting_date = date('Y-m-d');
			                $insert_attendance->posting_shift = $posting_shift;
			                $insert_attendance->att_data_id = $model->child_analyst . '-' . $model->line . '-' . $model->shift . '-' . date('Ymd', strtotime($posting_shift)) . '-' . $karyawan->NIK_SUN_FISH;
			                $insert_attendance->nik = $karyawan->NIK_SUN_FISH;
			                $insert_attendance->shift = $model->shift;

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
			                if ($insert_attendance->current_status == 'I') {
			                	$insert_attendance->current_status = 'O';
			                	$insert_attendance->check_out = $now;
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

			                $new_log = new ProdAttendanceLog;

			                if ($find_log->att_log_id == null) {
			                    $new_log->att_type = 'I';
			                } else {
			                    if ($find_log->att_type == 'I') {
			                        $new_log->att_type = 'O';
			                    } else {
			                    	$new_log->att_type = 'I';
			                    }
			                }
			                $new_log->att_data_id = $insert_attendance->att_data_id;
			                $new_log->last_update = $now;
			                if (!$new_log->save()) {
			                    return json_encode($new_log->errors);
			                }
			            } else {
			                return json_encode($insert_attendance->errors);
			            }
		            } else {
		            	\Yii::$app->session->setFlash("danger", "NIK is not registered ...");
		            }

		            
	        	}
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
        ->limit(10)
        ->all();

        $attendance_log = ProdAttendanceLog::find()
        ->select([
        	'nik' => 'PROD_ATTENDANCE_DATA.nik', 'name' => 'PROD_ATTENDANCE_DATA.name', 'att_type', 'PROD_ATTENDANCE_LOG.last_update'
        ])
        ->joinWith('prodAttendanceData')
        ->where([
        	'PROD_ATTENDANCE_DATA.child_analyst' => $model->child_analyst,
            'PROD_ATTENDANCE_DATA.line' => $model->line,
            'PROD_ATTENDANCE_DATA.posting_shift' => $posting_shift
        ])
        ->orderBy('PROD_ATTENDANCE_LOG.last_update DESC')
        //->limit(10)
        ->all();

        $total_mp = ProdAttendanceData::find()
        ->where([
            'child_analyst' => $model->child_analyst,
            'line' => $model->line,
            'posting_shift' => $posting_shift,
            'current_status' => 'I'
        ])
        ->count();

        return $this->render('index', [
            'model' => $model,
            'attendance_data' => $attendance_data,
            'attendance_log' => $attendance_log,
            'total_mp' => $total_mp,
        ]);
	}
}