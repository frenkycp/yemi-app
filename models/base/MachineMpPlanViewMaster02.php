<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.MACHINE_MP_PLAN_VIEW_MASTER_02".
 *
 * @property string $master_id
 * @property string $mesin_id
 * @property string $machine_desc
 * @property string $location
 * @property string $area
 * @property string $mesin_periode
 * @property string $master_plan_maintenance
 * @property string $year
 * @property string $period
 * @property integer $week
 * @property integer $count_list
 * @property integer $count_open
 * @property integer $count_close
 * @property string $aliasModel
 */
abstract class MachineMpPlanViewMaster02 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.MACHINE_MP_PLAN_VIEW_MASTER_02';
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
            [['master_id', 'mesin_id', 'machine_desc', 'location', 'area', 'mesin_periode', 'master_plan_maintenance', 'year', 'period'], 'string'],
            [['week', 'count_list', 'count_open', 'count_close'], 'integer'],
            [['count_open', 'count_close'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'master_id' => 'Master ID',
            'mesin_id' => 'Mesin ID',
            'machine_desc' => 'Machine Desc',
            'location' => 'Location',
            'area' => 'Area',
            'mesin_periode' => 'Mesin Periode',
            'master_plan_maintenance' => 'Master Plan Maintenance',
            'year' => 'Year',
            'period' => 'Period',
            'week' => 'Week',
            'count_list' => 'Count List',
            'count_open' => 'Count Open',
            'count_close' => 'Count Close',
        ];
    }




}
