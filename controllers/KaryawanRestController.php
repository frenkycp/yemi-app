<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\Karyawan;

class KaryawanRestController extends Controller
{
    public function actionGetInfo($nik = '')
    {
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($nik == '') {
            $tmp_karyawan = Karyawan::find()
            ->select(['NIK', 'NIK_SUN_FISH', 'NAMA_KARYAWAN', 'DEPARTEMEN', 'SECTION'])
            ->where(['AKTIF' => 'Y'])
            ->all();
        } else {
            $tmp_karyawan = Karyawan::find()
            ->select(['NIK', 'NIK_SUN_FISH', 'NAMA_KARYAWAN', 'DEPARTEMEN', 'SECTION'])
            ->where(['OR', ['NIK_SUN_FISH' => $nik], ['NIK' => $nik]])->one();
        }
    	

    	if (!$tmp_karyawan) {
    		return 'NIK not found';
    	}

    	return $tmp_karyawan;
    }
}