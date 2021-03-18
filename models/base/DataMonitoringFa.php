<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.DATA_MONITORING_FA".
 *
 * @property string $line
 * @property string $lastupdated
 * @property string $upload_date
 * @property integer $delay_second
 * @property integer $left_pos
 * @property integer $top_pos
 * @property integer $visible
 * @property string $aliasModel
 */
abstract class DataMonitoringFa extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.DATA_MONITORING_FA';
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
            [['lastupdated', 'upload_date'], 'safe'],
            [['delay_second', 'left_pos', 'top_pos', 'visible'], 'integer'],
            [['line'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'line' => 'Line',
            'lastupdated' => 'Lastupdated',
            'upload_date' => 'Upload Date',
            'delay_second' => 'Delay Second',
            'left_pos' => 'Left Pos',
            'top_pos' => 'Top Pos',
            'visible' => 'Visible',
        ];
    }




}
