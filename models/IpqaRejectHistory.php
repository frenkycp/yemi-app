<?php

namespace app\models;

use Yii;
use \app\models\base\IpqaRejectHistory as BaseIpqaRejectHistory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.IPQA_REJECT_HISTORY".
 */
class IpqaRejectHistory extends BaseIpqaRejectHistory
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
