<?php

namespace app\models;

use Yii;
use \app\models\base\CostCenter as BaseCostCenter;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.COST_CENTER".
 */
class CostCenter extends BaseCostCenter
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

    public function getDeptSection()
    {
        return $this->CC_GROUP . ' - ' . $this->CC_DESC;
    }
}
