<?php

namespace app\models;

use Yii;
use \app\models\base\GojekOrderTbl as BaseGojekOrderTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GOJEK_ORDER_TBL".
 */
class GojekOrderTbl extends BaseGojekOrderTbl
{
    public $stat_open, $stat_close, $stat_total;

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
                # custom validation rules
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'slip_id' => 'Slip Num.',
                'item' => 'Item',
                'item_desc' => 'Item Description',
                'from_loc' => 'From',
                'to_loc' => 'To',
                'source' => 'Source',
                'issued_date' => 'Issued Date',
                'daparture_date' => 'Daparture Date',
                'arrival_date' => 'Arrival Date',
                'GOJEK_ID' => 'Driver NIK',
                'GOJEK_DESC' => 'Driver Name',
                'GOJEK_VALUE' => 'Gojek  Value',
                'NIK_REQUEST' => 'Nik  Request',
                'NAMA_KARYAWAN' => 'Requestor',
                'STAT' => 'Status',
            ]
        );
    }
}
