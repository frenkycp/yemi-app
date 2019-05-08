<?php

namespace app\models;

use Yii;
use \app\models\base\IpqaStatusTbl as BaseIpqaStatusTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.IPQA_STATUS_TBL".
 */
class IpqaStatusTbl extends BaseIpqaStatusTbl
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
