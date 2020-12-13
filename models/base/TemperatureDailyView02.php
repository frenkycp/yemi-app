<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.TEMPERATURE_DAILY_VIEW_02".
 *
 * @property string $PERIOD
 * @property string $POST_DATE
 * @property string $NIK
 * @property string $NAMA_KARYAWAN
 * @property string $COST_CENTER
 * @property string $COST_CENTER_DESC
 * @property string $HOST
 * @property double $TEMPERATURE
 * @property string $TEMPERATURE_CATEGORY
 * @property string $LAST_UPDATE
 * @property string $aliasModel
 */
abstract class TemperatureDailyView02 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.TEMPERATURE_DAILY_VIEW_02';
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
            [['POST_DATE', 'LAST_UPDATE'], 'safe'],
            [['TEMPERATURE'], 'number'],
            [['TEMPERATURE_CATEGORY'], 'required'],
            [['PERIOD'], 'string', 'max' => 7],
            [['NIK', 'COST_CENTER'], 'string', 'max' => 10],
            [['NAMA_KARYAWAN'], 'string', 'max' => 100],
            [['COST_CENTER_DESC', 'HOST'], 'string', 'max' => 50],
            [['TEMPERATURE_CATEGORY'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PERIOD' => 'Period',
            'POST_DATE' => 'Post Date',
            'NIK' => 'Nik',
            'NAMA_KARYAWAN' => 'Nama Karyawan',
            'COST_CENTER' => 'Cost Center',
            'COST_CENTER_DESC' => 'Cost Center Desc',
            'HOST' => 'Host',
            'TEMPERATURE' => 'Temperature',
            'TEMPERATURE_CATEGORY' => 'Temperature Category',
            'LAST_UPDATE' => 'Last Update',
        ];
    }




}
