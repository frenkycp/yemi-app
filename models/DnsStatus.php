<?php

namespace app\models;

use Yii;
use \app\models\base\DnsStatus as BaseDnsStatus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.DNS_STATUS".
 */
class DnsStatus extends BaseDnsStatus
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
}
