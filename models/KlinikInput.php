<?php

namespace app\models;

use Yii;
use \app\models\base\KlinikInput as BaseKlinikInput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_klinik_input".
 */
class KlinikInput extends BaseKlinikInput
{
    public $input_date;

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
                [['nik', 'anamnesa', 'root_cause', 'diagnosa'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'nik' => 'NIK',
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
}
