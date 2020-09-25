<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.MTTR_MTBF_DATA_VIEW".
 *
 * @property string $period
 * @property string $mesin_id
 * @property string $mesin_nama
 * @property string $location
 * @property string $area
 * @property integer $down_time
 * @property integer $non_down_time
 * @property integer $down_time_number
 * @property integer $working_days
 * @property integer $mttr
 * @property integer $mtbf
 * @property string $aliasModel
 */
abstract class MttrMtbfDataView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.MTTR_MTBF_DATA_VIEW';
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
            [['down_time', 'non_down_time', 'down_time_number', 'working_days', 'mttr', 'mtbf'], 'integer'],
            [['period'], 'string', 'max' => 4000],
            [['mesin_id'], 'string', 'max' => 10],
            [['mesin_nama'], 'string', 'max' => 100],
            [['location', 'area'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period' => 'Period',
            'mesin_id' => 'Mesin ID',
            'mesin_nama' => 'Mesin Nama',
            'location' => 'Location',
            'area' => 'Area',
            'down_time' => 'Down Time',
            'non_down_time' => 'Non Down Time',
            'down_time_number' => 'Down Time Number',
            'working_days' => 'Working Days',
            'mttr' => 'Mttr',
            'mtbf' => 'Mtbf',
        ];
    }




}
