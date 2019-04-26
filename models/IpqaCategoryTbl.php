<?php

namespace app\models;

use Yii;
use \app\models\base\IpqaCategoryTbl as BaseIpqaCategoryTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.IPQA_CATEGORY_TBL".
 */
class IpqaCategoryTbl extends BaseIpqaCategoryTbl
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
