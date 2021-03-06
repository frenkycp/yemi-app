<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.CLIENT_LOG".
 *
 * @property string $seq
 * @property string $machine_name
 * @property string $ip_address
 * @property string $mac_address
 * @property string $reply_status
 * @property double $round_trip_time
 * @property string $last_update
 * @property string $color
 * @property string $period
 * @property string $tanggal
 * @property double $jam_no
 * @property double $shift
 * @property string $day_name
 * @property double $count_all
 * @property double $count_merah
 * @property string $aliasModel
 */
abstract class ClientLog extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.CLIENT_LOG';
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
            [['round_trip_time', 'jam_no', 'shift', 'count_all', 'count_merah'], 'number'],
            [['last_update', 'tanggal'], 'safe'],
            [['machine_name', 'ip_address', 'mac_address', 'reply_status', 'color', 'day_name'], 'string', 'max' => 50],
            [['period'], 'string', 'max' => 7]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'seq' => 'Seq',
            'machine_name' => 'Machine Name',
            'ip_address' => 'Ip Address',
            'mac_address' => 'Mac Address',
            'reply_status' => 'Reply Status',
            'round_trip_time' => 'Round Trip Time',
            'last_update' => 'Last Update',
            'color' => 'Color',
            'period' => 'Period',
            'tanggal' => 'Tanggal',
            'jam_no' => 'Jam No',
            'shift' => 'Shift',
            'day_name' => 'Day Name',
            'count_all' => 'Count All',
            'count_merah' => 'Count Merah',
        ];
    }




}
