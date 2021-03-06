<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.TEMPERATURE_OVER_ACTION".
 *
 * @property string $ID
 * @property string $POST_DATE
 * @property string $EMP_ID
 * @property string $EMP_NAME
 * @property integer $SHIFT
 * @property string $LAST_CHECK
 * @property double $OLD_TEMPERATURE
 * @property double $NEW_TEMPERATURE
 * @property integer $NEXT_ACTION
 * @property string $aliasModel
 */
abstract class TemperatureOverAction extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.TEMPERATURE_OVER_ACTION';
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
            [['POST_DATE', 'LAST_CHECK'], 'safe'],
            [['SHIFT', 'NEXT_ACTION'], 'integer'],
            [['OLD_TEMPERATURE', 'NEW_TEMPERATURE'], 'number'],
            [['ID', 'EMP_ID'], 'string', 'max' => 50],
            [['EMP_NAME'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'POST_DATE' => 'Post Date',
            'EMP_ID' => 'Emp ID',
            'EMP_NAME' => 'Emp Name',
            'SHIFT' => 'Shift',
            'LAST_CHECK' => 'Last Check',
            'OLD_TEMPERATURE' => 'Old Temperature',
            'NEW_TEMPERATURE' => 'New Temperature',
            'NEXT_ACTION' => 'Next Action',
        ];
    }




}
