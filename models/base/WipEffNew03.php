<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.WIP_EFF_NEW_03".
 *
 * @property string $child_analyst
 * @property string $child_analyst_desc
 * @property string $period
 * @property string $post_date
 * @property string $LINE
 * @property string $SMT_SHIFT
 * @property string $child_all
 * @property string $child_desc_all
 * @property double $qty_all
 * @property double $std_all
 * @property double $lt_std
 * @property double $lt_gross
 * @property double $planed_loss_minute
 * @property double $out_section_minute
 * @property double $dandori_minute
 * @property double $break_down_minute
 * @property double $operating_loss_minute
 * @property double $working_time
 * @property double $operating_ratio
 * @property double $working_ratio
 * @property double $TOTAL_POINT_FCA
 * @property integer $POINT_SMT
 * @property double $POINT_FCA
 * @property string $aliasModel
 */
abstract class WipEffNew03 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.WIP_EFF_NEW_03';
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
            [['post_date'], 'safe'],
            [['qty_all', 'std_all', 'lt_std', 'lt_gross', 'planed_loss_minute', 'out_section_minute', 'dandori_minute', 'break_down_minute', 'operating_loss_minute', 'working_time', 'operating_ratio', 'working_ratio', 'TOTAL_POINT_FCA', 'POINT_FCA'], 'number'],
            [['POINT_SMT'], 'integer'],
            [['child_analyst', 'period'], 'string', 'max' => 6],
            [['child_analyst_desc', 'child_desc_all'], 'string', 'max' => 50],
            [['LINE'], 'string', 'max' => 13],
            [['SMT_SHIFT'], 'string', 'max' => 20],
            [['child_all'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'child_analyst' => 'Child Analyst',
            'child_analyst_desc' => 'Child Analyst Desc',
            'period' => 'Period',
            'post_date' => 'Post Date',
            'LINE' => 'Line',
            'SMT_SHIFT' => 'Smt Shift',
            'child_all' => 'Child All',
            'child_desc_all' => 'Child Desc All',
            'qty_all' => 'Qty All',
            'std_all' => 'Std All',
            'lt_std' => 'Lt Std',
            'lt_gross' => 'Lt Gross',
            'planed_loss_minute' => 'Planed Loss Minute',
            'out_section_minute' => 'Out Section Minute',
            'dandori_minute' => 'Dandori Minute',
            'break_down_minute' => 'Break Down Minute',
            'operating_loss_minute' => 'Operating Loss Minute',
            'working_time' => 'Working Time',
            'operating_ratio' => 'Operating Ratio',
            'working_ratio' => 'Working Ratio',
            'TOTAL_POINT_FCA' => 'Total Point Fca',
            'POINT_SMT' => 'Point Smt',
            'POINT_FCA' => 'Point Fca',
        ];
    }




}
