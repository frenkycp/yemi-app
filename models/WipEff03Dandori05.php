<?php

namespace app\models;

use Yii;
use \app\models\base\WipEff03Dandori05 as BaseWipEff03Dandori05;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_03_DANDORI_05".
 */
class WipEff03Dandori05 extends BaseWipEff03Dandori05
{
    public $AVG_ITEM;

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
