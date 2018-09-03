<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.VISUAL_PICKING_VIEW_02".
 *
 * @property string $year
 * @property string $period
 * @property integer $week
 * @property string $req_date
 * @property string $analyst
 * @property string $analyst_desc
 * @property integer $slip_count
 * @property integer $slip_open
 * @property integer $slip_close
 * @property integer $total_ordered
 * @property integer $total_started
 * @property integer $total_completed
 * @property string $aliasModel
 */
abstract class VisualPickingView02 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.VISUAL_PICKING_VIEW_02';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_wsus');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'period', 'analyst', 'analyst_desc'], 'string'],
            [['week', 'slip_count', 'slip_open', 'slip_close', 'total_ordered', 'total_started', 'total_completed'], 'integer'],
            [['req_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'year' => 'Year',
            'period' => 'Period',
            'week' => 'Week',
            'req_date' => 'Req Date',
            'analyst' => 'Analyst',
            'analyst_desc' => 'Analyst Desc',
            'slip_count' => 'Slip Count',
            'slip_open' => 'Slip Open',
            'slip_close' => 'Slip Close',
            'total_ordered' => 'Total Ordered',
            'total_started' => 'Total Started',
            'total_completed' => 'Total Completed',
        ];
    }




}
