<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SMT_PCB_LOG_WORKING_RATIO_BY_HOUR_RESULT".
 *
 * @property string $start_time_hour
 * @property string $mounter_stage
 * @property double $tot_mount_ct_markrec_ct_transfer_ct
 * @property double $working_ratio_by_hour
 * @property string $stage
 * @property string $shift_date
 * @property string $machine
 * @property string $line
 * @property string $aliasModel
 */
abstract class SmtWorkingRatioByHourResult extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SMT_PCB_LOG_WORKING_RATIO_BY_HOUR_RESULT';
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
            [['start_time_hour', 'shift_date'], 'safe'],
            [['tot_mount_ct_markrec_ct_transfer_ct', 'working_ratio_by_hour'], 'number'],
            [['mounter_stage', 'stage', 'machine', 'line'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'start_time_hour' => 'Start Time Hour',
            'mounter_stage' => 'Mounter Stage',
            'tot_mount_ct_markrec_ct_transfer_ct' => 'Tot Mount Ct Markrec Ct Transfer Ct',
            'working_ratio_by_hour' => 'Working Ratio By Hour',
            'stage' => 'Stage',
            'shift_date' => 'Shift Date',
            'machine' => 'Machine',
            'line' => 'Line',
        ];
    }




}
