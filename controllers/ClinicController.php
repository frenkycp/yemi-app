<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\models\KlinikInput;
use app\models\KlinikHandle;

class ClinicController extends controller
{
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->layout = 'clean';
		$available_beds = 3;
		$doctor_status = KlinikHandle::find()->where(['pk' => 'doctor'])->one()->status;
		$nurse_status = KlinikHandle::find()->where(['pk' => 'nurse'])->one()->status;

		$data = KlinikInput::find()
		->where([
			'date(pk)' => date('Y-m-d')
		])
		->orderBy('confirm, masuk DESC')
		//->limit(5)
		->all();

		$today_visitor = KlinikInput::find()
		->where([
			'date(pk)' => date('Y-m-d')
		])
		->count();

		$monthly_visitor = KlinikInput::find()
		->where([
			'extract(year_month FROM pk)' => date('Ym')
		])
		->count();

		$bed_used = KlinikInput::find()
		->where('keluar IS NULL')
		->andWhere([
			'date(pk)' => date('Y-m-d')
		])
		->andWhere([
			'opsi' => 2
		])
		->count();

		$available_beds -= $bed_used;
		if ($available_beds < 0) {
			$available_beds = 0;
		}

		if ($doctor_status == 1) {
			$doctor_data = [
				'status' => 'ADA',
				'bg_color' => 'bg-green'
			];
		} else {
			$doctor_data = [
				'status' => 'TIDAK ADA',
				'bg_color' => 'bg-orange'
			];
		}

		if ($nurse_status == 1) {
			$nurse_data = [
				'status' => 'ADA',
				'bg_color' => 'bg-green'
			];
		} else {
			$nurse_data = [
				'status' => 'TIDAK ADA',
				'bg_color' => 'bg-orange'
			];
		}

		return $this->render('index', [
			'today_visitor' => $today_visitor,
			'monthly_visitor' => $monthly_visitor,
			'available_beds' => $available_beds,
			'doctor_data' => $doctor_data,
			'nurse_data' => $nurse_data,
			'data' => $data,
		]);
	}

	public function actionIndexUpdate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$available_beds = 3;
		$doctor_status = KlinikHandle::find()->where(['pk' => 'doctor'])->one()->status;
		$nurse_status = KlinikHandle::find()->where(['pk' => 'nurse'])->one()->status;

		$data_clinic = KlinikInput::find()
		->where([
			'date(pk)' => date('Y-m-d')
		])
		->orderBy('confirm, masuk DESC')
		//->limit(5)
		->all();

		$today_visitor = KlinikInput::find()
		->where([
			'date(pk)' => date('Y-m-d')
		])
		->count();

		$monthly_visitor = KlinikInput::find()
		->where([
			'extract(year_month FROM pk)' => date('Ym')
		])
		->count();

		$bed_used = KlinikInput::find()
		->where('keluar IS NULL')
		->andWhere([
			'date(pk)' => date('Y-m-d')
		])
		->andWhere([
			'opsi' => 2
		])
		->count();

		$available_beds -= $bed_used;
		if ($available_beds < 0) {
			$available_beds = 0;
		}

		if ($doctor_status == 1) {
			$doctor_data = [
				'status' => 'ADA',
				'bg_color' => 'bg-green'
			];
		} else {
			$doctor_data = [
				'status' => 'TIDAK ADA',
				'bg_color' => 'bg-orange'
			];
		}

		if ($nurse_status == 1) {
			$nurse_data = [
				'status' => 'ADA',
				'bg_color' => 'bg-green'
			];
		} else {
			$nurse_data = [
				'status' => 'TIDAK ADA',
				'bg_color' => 'bg-orange'
			];
		}

		$doctor_content = '<div class="small-box ' . $doctor_data['bg_color'] . '">
            <div class="inner">
                <h3>dokter</h3>
                <p>&nbsp;' . $doctor_data['status'] . '</p>
            </div>
            <a class="small-box-footer"></a>
        </div>';

        $nurse_content = '<div class="small-box ' . $nurse_data['bg_color'] . '">
            <div class="inner">
                <h3>Perawat</h3>
                <p>&nbsp;' . $nurse_data['status'] . '</p>
            </div>
            <a class="small-box-footer"></a>
        </div>';

        $table_container = '';
        foreach ($data_clinic as $key => $value) {
	        $total_this_month = KlinikInput::find()
	        ->select([
	            'nik',
	            'total1' => 'SUM(CASE WHEN opsi = 1 THEN 1 ELSE 0 END)',
	            'total2' => 'SUM(CASE WHEN opsi = 2 THEN 1 ELSE 0 END)',
	            'total3' => 'SUM(CASE WHEN opsi = 3 THEN 1 ELSE 0 END)',
	        ])
	        ->where([
	            'EXTRACT(year_month FROM pk)' => date('Ym'),
	            'nik' => $value->nik
	        ])
	        ->groupBy('nik')
	        ->one();

	        if ($value->confirm == 0) {
	            $konfirmasi = [
	                'text' => 'BELUM',
	                'class' => 'text-red'
	            ];
	        } else {
	            $konfirmasi = [
	                'text' => 'SUDAH',
	                'class' => 'text-green'
	            ];
	        }

	        if ($value->handleby == 'nurse') {
	            $handled_by = 'PERAWAT';
	        } else {
	            $handled_by = 'DOKTER';
	        }

	        if ($value->opsi == 1) {
	            $category = 'PERIKSA';
	            $bed_rest_time = date('H:i', strtotime($value->pk));

	        } elseif ($value->opsi == 2) {
	            $category = 'ISTIRAHAT SAKIT';
	            $bed_rest_time = date('H:i', strtotime($value->masuk)) . ' - ' . date('H:i', strtotime($value->keluar));
	        }else {
	            $category = 'LAKTASI';
	            $bed_rest_time = date('H:i', strtotime($value->masuk)) . ' - ' . date('H:i', strtotime($value->keluar));
	        }
	        $masuk = '-';
	        if ($value->masuk != null) {
	            $masuk = date('H:i', strtotime($value->masuk));
	        }
	        $keluar = '-';
	        if ($value->keluar != null) {
	            $keluar = date('H:i', strtotime($value->keluar));
	        }
	        $table_container .= '<tr style="letter-spacing: 2px;">
	            <td class="text-center">' . $value->nik . '</td>
	            <td>' . $value->nama . '</td>
	            <td>' . $value->dept . '</td>
	            <td>' . $category . '</td>
	            <td class="text-center">' . $masuk . '</td>
	            <td class="text-center">' . $keluar . '</td>
	            <td class="text-center">' . $total_this_month->total1 . ' / ' . $total_this_month->total2 . ' / ' . $total_this_month->total3 . '</td>
	            <td class="text-center ' . $konfirmasi['class'] . '">' . $konfirmasi['text'] . '</td>
	        </tr>';
	    }

	    if (count($data_clinic) == 0) {
	        $table_container = '<tr>
	        <td colspan="8">No Visitor Today</td>
	        </tr>';
	    }

		$data = [
			'today_visitor' => $today_visitor,
			'monthly_visitor' => $monthly_visitor,
			'available_beds' => $available_beds,
			'doctor_content' => $doctor_content,
			'nurse_content' => $nurse_content,
			'table_container' => $table_container,
		];

		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
}