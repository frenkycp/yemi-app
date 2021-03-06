<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.CIS_CLIENT_IP_ADDRESS".
 *
 * @property integer $id
 * @property string $ip_address
 * @property string $login_datetime
 * @property string $login_as
 * @property integer $login_as_id
 * @property integer $status
 * @property string $aliasModel
 */
abstract class CisClientIpAddress extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cis_client_ip_address';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip_address', 'login_as'], 'string'],
            [['login_datetime'], 'safe'],
            [['login_as_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip_address' => 'Ip Address',
            'login_datetime' => 'Login Datetime',
            'login_as' => 'Login As',
            'login_as_id' => 'Login As ID',
            'status' => 'Status',
        ];
    }




}
