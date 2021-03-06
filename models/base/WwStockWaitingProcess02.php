<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.WW_STOCK_WAITING_PROCESS_02".
 *
 * @property string $mesin_id
 * @property string $mesin_description
 * @property string $kelompok
 * @property string $lot_number
 * @property double $lot_qty
 * @property string $model_group
 * @property string $parent
 * @property string $parent_desc
 * @property string $gmc
 * @property string $gmc_desc
 * @property string $start_date
 * @property string $end_date
 * @property string $next_process_date
 * @property double $days_waiting
 * @property double $hours_waiting
 * @property integer $total_next_process
 * @property string $plan_stats
 * @property string $plan_run
 * @property string $aliasModel
 */
abstract class WwStockWaitingProcess02 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.WW_STOCK_WAITING_PROCESS_02';
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
            [['mesin_id'], 'required'],
            [['lot_qty', 'days_waiting', 'hours_waiting'], 'number'],
            [['start_date', 'end_date', 'next_process_date'], 'safe'],
            [['total_next_process'], 'integer'],
            [['mesin_id', 'kelompok', 'lot_number', 'model_group', 'gmc_desc'], 'string', 'max' => 50],
            [['mesin_description'], 'string', 'max' => 100],
            [['parent'], 'string', 'max' => 20],
            [['parent_desc'], 'string', 'max' => 250],
            [['gmc'], 'string', 'max' => 11],
            [['plan_stats', 'plan_run'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mesin_id' => 'Mesin ID',
            'mesin_description' => 'Mesin Description',
            'kelompok' => 'Kelompok',
            'lot_number' => 'Lot Number',
            'lot_qty' => 'Lot Qty',
            'model_group' => 'Model Group',
            'parent' => 'Parent',
            'parent_desc' => 'Parent Desc',
            'gmc' => 'Gmc',
            'gmc_desc' => 'Gmc Desc',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'next_process_date' => 'Next Process Date',
            'days_waiting' => 'Days Waiting',
            'hours_waiting' => 'Hours Waiting',
            'total_next_process' => 'Total Next Process',
            'plan_stats' => 'Plan Stats',
            'plan_run' => 'Plan Run',
        ];
    }




}
