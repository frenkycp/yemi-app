<?php

namespace app\models;

use Yii;
use \app\models\base\CisClientIpAddress as BaseCisClientIpAddress;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.CIS_CLIENT_IP_ADDRESS".
 */
class CisClientIpAddress extends BaseCisClientIpAddress
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'ip_address' => 'IP Address',
                'login_datetime' => 'Login Datetime',
                'login_as' => 'Login As',
                'status' => 'Status',
            ]
        );
    }
}
