<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "weekly_summary_view".
 *
 * @property integer $period
 * @property integer $week
 * @property integer $week_no
 * @property string $category
 * @property string $plan_qty
 * @property string $actual_qty
 * @property string $balance_qty
 * @property string $total_delay
 * @property string $on_time_completion
 * @property integer $plan_export
 * @property integer $actual_export
 * @property integer $balance_export
 * @property string $remark
 * @property integer $flag
 * @property string $aliasModel
 */
abstract class WeeklySummaryView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'weekly_summary_view';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mis7');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period', 'week', 'week_no', 'plan_export', 'actual_export', 'balance_export', 'flag'], 'integer'],
            [['plan_qty', 'actual_qty', 'balance_qty', 'total_delay', 'on_time_completion'], 'number'],
            [['remark'], 'string'],
            [['category'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period' => 'Period',
            'week' => 'Week',
            'week_no' => 'Week No',
            'category' => 'Category',
            'plan_qty' => 'Plan Qty',
            'actual_qty' => 'Actual Qty',
            'balance_qty' => 'Balance Qty',
            'total_delay' => 'Total Delay',
            'on_time_completion' => 'On Time Completion',
            'plan_export' => 'Plan Export',
            'actual_export' => 'Actual Export',
            'balance_export' => 'Balance Export',
            'remark' => 'Remark',
            'flag' => 'Flag',
        ];
    }




}
