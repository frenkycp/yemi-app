<?php

namespace app\models;

use Yii;
use \app\models\base\SernoInput as BaseSernoInput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_input".
 */
class SernoInput extends BaseSernoInput
{
    public $etd_ship, $destination, $week_no, $total, $status, $pdf_file, $total_ng, $invoice, $vms, $port, $so, $description, $speaker_model, $dst, $prod_output_qty, $in_transit_qty, $finish_goods_qty, $stock_qty, $total_kubikasi, $period, $qty_product, $efficiency, $total_data, $total_check, $total_no_check, $total_ok, $total_lot_out, $total_repair, $fa_output_qty, $fa_output_ok_qty, $finish_good_ok_qty, $rfid_no, $start_time, $end_time, $mp_time_single, $cntr, $days_diff, $mp, $working_time, $part_name;

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
                'num' => 'Num',
                'pk' => 'Pk',
                'gmc' => 'GMC',
                'line' => 'Line',
                'proddate' => 'Prod. Date',
                'sernum' => 'Serial No.',
                'flo' => 'FLO No.',
                'palletnum' => 'Palletnum',
                'qa_ng' => 'NG Remark',
                'qa_ng_date' => 'NG Date',
                'qa_ok' => 'Status OK',
                'qa_ok_date' => 'OK Date',
                'plan' => 'Plan',
                'adv' => 'Adv',
                'ship' => 'Ship',
                'vms' => 'VMS',
                'etd_ship' => 'ETD',
                'so' => 'Sales Order',
            ]
        );
    }

    public static function getDb()
    {
        return Yii::$app->get('db_mis7');
    }

    public function getSernoOutput()
    {
        return $this->hasOne(SernoOutput::className(), ['pk' => 'plan']);
    }

    public function getSernoMaster()
    {
        return $this->hasOne(SernoMaster::className(), ['gmc' => 'gmc']);
    }

    public function getPartName()
    {
        $sernoMaster = SernoMaster::find()->where(['gmc' => $this->gmc])->one();
        return $sernoMaster->model . ' // ' . $sernoMaster->color . ' // ' . $sernoMaster->dest;
    }

    public function getPackage()
    {
        $sernoMaster = SernoMaster::find()->where(['gmc' => $this->gmc])->one();
        $package = '-';
        if ($sernoMaster->package != '') {
            $package = $sernoMaster->package;
        }
        return $package;
    }

    public function getItemM3()
    {
        return $this->hasOne(ShipItemM3::className(), ['ITEM' => 'gmc']);
    }

    public function getSernoRfid()
    {
        return $this->hasOne(SernoRfid::className(), ['flo' => 'flo']);
    }

    public function getTotalMp()
    {
        $total_mp = SernoMp::find()
        ->where([
            'tgl' => $this->proddate,
            'line' => $this->line,
            'status' => 0
        ])
        ->count();

        return $total_mp;
    }
}
