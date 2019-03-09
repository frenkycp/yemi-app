<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.WIP_EFF_NEW_10".
 *
 * @property string $child_analyst
 * @property string $child_analyst_desc
 * @property string $period
 * @property string $LINE
 * @property double $lt_std
 * @property double $lt_gross
 * @property double $planed_loss_minute
 * @property double $out_section_minute
 * @property double $dandori_minute
 * @property double $break_down_minute
 * @property double $operating_loss_minute
 * @property integer $jumlah_hari
 * @property integer $jumlah_menit
 * @property double $operating_ratio
 * @property double $working_ratio
 * @property string $aliasModel
 */
abstract class WipEffNew10 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.WIP_EFF_NEW_10';
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
            [['child_analyst', 'child_analyst_desc', 'period', 'LINE'], 'string'],
            [['lt_std', 'lt_gross', 'planed_loss_minute', 'out_section_minute', 'dandori_minute', 'break_down_minute', 'operating_loss_minute', 'operating_ratio', 'working_ratio'], 'number'],
            [['jumlah_hari', 'jumlah_menit'], 'integer']
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
            'LINE' => 'Line',
            'lt_std' => 'Lt Std',
            'lt_gross' => 'Lt Gross',
            'planed_loss_minute' => 'Planed Loss Minute',
            'out_section_minute' => 'Out Section Minute',
            'dandori_minute' => 'Dandori Minute',
            'break_down_minute' => 'Break Down Minute',
            'operating_loss_minute' => 'Operating Loss Minute',
            'jumlah_hari' => 'Jumlah Hari',
            'jumlah_menit' => 'Jumlah Menit',
            'operating_ratio' => 'Operating Ratio',
            'working_ratio' => 'Working Ratio',
        ];
    }




}
