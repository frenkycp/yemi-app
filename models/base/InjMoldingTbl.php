<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.INJ_MOLDING_TBL".
 *
 * @property string $MOLDING_ID
 * @property string $MOLDING_NAME
 * @property string $MACHINE_ID
 * @property string $MACHINE_DESC
 * @property integer $TOTAL_COUNT
 * @property integer $TARGET_COUNT
 * @property double $SHOT_PCT
 * @property integer $MOLDING_STATUS
 * @property string $LAST_UPDATE
 * @property string $UPDATE_BY_ID
 * @property string $UPDATE_BY_NAME
 * @property string $UPDATE_DATETIME
 * @property string $aliasModel
 */
abstract class InjMoldingTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.INJ_MOLDING_TBL';
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
            [['MOLDING_ID'], 'required'],
            [['TOTAL_COUNT', 'TARGET_COUNT', 'MOLDING_STATUS'], 'integer'],
            [['SHOT_PCT'], 'number'],
            [['LAST_UPDATE', 'UPDATE_DATETIME'], 'safe'],
            [['MOLDING_ID', 'MACHINE_ID', 'UPDATE_BY_ID'], 'string', 'max' => 50],
            [['MOLDING_NAME'], 'string', 'max' => 150],
            [['MACHINE_DESC', 'UPDATE_BY_NAME'], 'string', 'max' => 250],
            [['MOLDING_ID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MOLDING_ID' => 'Molding ID',
            'MOLDING_NAME' => 'Molding Name',
            'MACHINE_ID' => 'Machine ID',
            'MACHINE_DESC' => 'Machine Desc',
            'TOTAL_COUNT' => 'Total Count',
            'TARGET_COUNT' => 'Target Count',
            'SHOT_PCT' => 'Shot Pct',
            'MOLDING_STATUS' => 'Molding Status',
            'LAST_UPDATE' => 'Last Update',
            'UPDATE_BY_ID' => 'Update By ID',
            'UPDATE_BY_NAME' => 'Update By Name',
            'UPDATE_DATETIME' => 'Update Datetime',
        ];
    }




}
