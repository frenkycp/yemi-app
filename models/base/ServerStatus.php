<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "dbo.SERVER_STATUS".
 *
 * @property string $server_mac_address
 * @property string $server_ip
 * @property string $server_name
 * @property string $reply_status
 * @property double $reply_roundtriptime
 * @property double $memory
 * @property double $memory_used
 * @property double $memory_free
 * @property double $memory_used_pct
 * @property double $memory_free_pct
 * @property double $c_driveinfo_capacity
 * @property double $c_driveinfo_used
 * @property double $c_driveinfo_freeSpace
 * @property double $c_driveinfo_used_pct
 * @property double $c_driveinfo_free_pct
 * @property double $d_driveinfo_capacity
 * @property double $d_driveinfo_used
 * @property double $d_driveinfo_freeSpace
 * @property double $d_driveinfo_used_pct
 * @property double $d_driveinfo_free_pct
 * @property string $last_update
 * @property double $down_time_minute
 * @property string $server_on_off
 * @property string $aliasModel
 */
abstract class ServerStatus extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dbo.SERVER_STATUS';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_server_status');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['server_mac_address'], 'required'],
            [['server_mac_address', 'server_ip', 'server_name', 'reply_status', 'server_on_off'], 'string'],
            [['reply_roundtriptime', 'memory', 'memory_used', 'memory_free', 'memory_used_pct', 'memory_free_pct', 'c_driveinfo_capacity', 'c_driveinfo_used', 'c_driveinfo_freeSpace', 'c_driveinfo_used_pct', 'c_driveinfo_free_pct', 'd_driveinfo_capacity', 'd_driveinfo_used', 'd_driveinfo_freeSpace', 'd_driveinfo_used_pct', 'd_driveinfo_free_pct', 'down_time_minute'], 'number'],
            [['last_update'], 'safe'],
            [['server_mac_address'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'server_mac_address' => 'Server Mac Address',
            'server_ip' => 'Server Ip',
            'server_name' => 'Server Name',
            'reply_status' => 'Reply Status',
            'reply_roundtriptime' => 'Reply Roundtriptime',
            'memory' => 'Memory',
            'memory_used' => 'Memory Used',
            'memory_free' => 'Memory Free',
            'memory_used_pct' => 'Memory Used Pct',
            'memory_free_pct' => 'Memory Free Pct',
            'c_driveinfo_capacity' => 'C Driveinfo Capacity',
            'c_driveinfo_used' => 'C Driveinfo Used',
            'c_driveinfo_freeSpace' => 'C Driveinfo Free Space',
            'c_driveinfo_used_pct' => 'C Driveinfo Used Pct',
            'c_driveinfo_free_pct' => 'C Driveinfo Free Pct',
            'd_driveinfo_capacity' => 'D Driveinfo Capacity',
            'd_driveinfo_used' => 'D Driveinfo Used',
            'd_driveinfo_freeSpace' => 'D Driveinfo Free Space',
            'd_driveinfo_used_pct' => 'D Driveinfo Used Pct',
            'd_driveinfo_free_pct' => 'D Driveinfo Free Pct',
            'last_update' => 'Last Update',
            'down_time_minute' => 'Down Time Minute',
            'server_on_off' => 'Server On Off',
        ];
    }




}
