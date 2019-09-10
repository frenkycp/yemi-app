<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.MACHINE_IOT_OUTPUT_DTR".
 *
 * @property string $trans_id
 * @property string $lot_number
 * @property integer $seq
 * @property string $mesin_id
 * @property string $mesin_description
 * @property string $kelompok
 * @property string $gmc
 * @property string $gmc_desc
 * @property double $lot_qty
 * @property string $start_date
 * @property string $end_date
 * @property integer $lead_time
 * @property integer $man_power_qty
 * @property string $status
 * @property string $aliasModel
 */
abstract class MachineIotOutputDtr extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.MACHINE_IOT_OUTPUT_DTR';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sql_server');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lot_number', 'mesin_id', 'mesin_description', 'kelompok', 'gmc', 'gmc_desc', 'status'], 'string'],
            [['seq', 'lead_time', 'man_power_qty'], 'integer'],
            [['lot_qty'], 'number'],
            [['start_date', 'end_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trans_id' => 'Trans ID',
            'lot_number' => 'Lot Number',
            'seq' => 'Seq',
            'mesin_id' => 'Mesin ID',
            'mesin_description' => 'Mesin Description',
            'kelompok' => 'Kelompok',
            'gmc' => 'Gmc',
            'gmc_desc' => 'Gmc Desc',
            'lot_qty' => 'Lot Qty',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'lead_time' => 'Lead Time',
            'man_power_qty' => 'Man Power Qty',
            'status' => 'Status',
        ];
    }




}
