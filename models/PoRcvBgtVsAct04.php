<?php

namespace app\models;

use Yii;
use \app\models\base\PoRcvBgtVsAct04 as BasePoRcvBgtVsAct04;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PO_RCV_BGT_VS_ACT_04".
 */
class PoRcvBgtVsAct04 extends BasePoRcvBgtVsAct04
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
