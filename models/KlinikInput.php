<?php

namespace app\models;

use Yii;
use \app\models\base\KlinikInput as BaseKlinikInput;
use yii\helpers\ArrayHelper;
use app\models\SunfishViewEmp;

/**
 * This is the model class for table "tb_klinik_input".
 */
class KlinikInput extends BaseKlinikInput
{
    public $input_date, $masuk2, $keluar2, $total1, $total2, $total3, $jumlah_karyawan, $total_minutes, $total_visit, $nama_obat, $jumlah_obat, $detail_obat;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['nik_sun_fish'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'nik' => 'NIK',
                'nik_sun_fish' => 'Employee',
                'dept' => 'Departemen',
                'opsi' => 'Keperluan',
                'anamnesa' => 'Gejala',
                'root_cause' => 'Penyebab',
                'obat1' => 'Obat 1',
                'obat2' => 'Obat 2',
                'obat3' => 'Obat 3',
                'obat4' => 'Obat 4',
                'obat5' => 'Obat 5',
                'handleby' => 'Paramedis'
            ]
        );
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            $tmp_karyawan = Karyawan::find()->where([
                'NIK_SUN_FISH' => $this->nik_sun_fish
            ])->one();
            $this->nik = $tmp_karyawan->NIK;

            $tmp_sunfish_data = SunfishViewEmp::find()->where(['Emp_no' => $this->nik_sun_fish])->one();
            if ($tmp_sunfish_data) {
                $this->cost_center_code = $tmp_sunfish_data->cost_center_code;
                $this->cost_center_name = $tmp_sunfish_data->cost_center_name;
            }

            return true;
        }
    }

    public function getObatLog($value='')
    {
        return $this->hasMany(KlinikObatLog::className(), ['klinik_input_pk' => 'klinik_input_id']);
    }
}
