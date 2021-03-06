<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.JOB_ORDER_VIEW4".
 *
 * @property string $PERIOD
 * @property string $DATE
 * @property string $LOC
 * @property double $UTILIZATION
 * @property double $EFFICIENCY
 * @property double $MOUNT_POINT
 * @property double $MOUNT_TIME
 * @property double $DANDORI
 * @property double $LOST_TIME
 * @property integer $COUNTER
 * @property string $aliasModel
 */
abstract class JobOrderView4 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.JOB_ORDER_VIEW4';
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
            [['PERIOD', 'DATE', 'LOC'], 'string'],
            [['UTILIZATION', 'EFFICIENCY', 'MOUNT_POINT', 'MOUNT_TIME', 'DANDORI', 'LOST_TIME'], 'number'],
            [['COUNTER'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PERIOD' => 'Period',
            'DATE' => 'Date',
            'LOC' => 'Loc',
            'UTILIZATION' => 'Utilization',
            'EFFICIENCY' => 'Efficiency',
            'MOUNT_POINT' => 'Mount  Point',
            'MOUNT_TIME' => 'Mount  Time',
            'DANDORI' => 'Dandori',
            'LOST_TIME' => 'Lost  Time',
            'COUNTER' => 'Counter',
        ];
    }




}
