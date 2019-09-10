<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.MACHINE_IOT_OUTPUT_HDR".
 *
 * @property string $lot_number
 * @property string $gmc
 * @property string $gmc_desc
 * @property double $lot_qty
 * @property string $start_date
 * @property string $end_date
 * @property integer $run_time
 * @property integer $iddle_time
 * @property integer $total_lead_time
 * @property integer $man_power_qty
 * @property string $aliasModel
 */
abstract class MachineIotOutputHdr extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.MACHINE_IOT_OUTPUT_HDR';
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
            [['lot_number'], 'required'],
            [['lot_number', 'gmc', 'gmc_desc'], 'string'],
            [['lot_qty'], 'number'],
            [['start_date', 'end_date'], 'safe'],
            [['run_time', 'iddle_time', 'total_lead_time', 'man_power_qty'], 'integer'],
            [['lot_number'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lot_number' => 'Lot Number',
            'gmc' => 'Gmc',
            'gmc_desc' => 'Gmc Desc',
            'lot_qty' => 'Lot Qty',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'run_time' => 'Run Time',
            'iddle_time' => 'Iddle Time',
            'total_lead_time' => 'Total Lead Time',
            'man_power_qty' => 'Man Power Qty',
        ];
    }




}
