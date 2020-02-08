<?php

namespace app\models;

use Yii;
use \app\models\base\ItemUncountableSummaryReport as BaseItemUncountableSummaryReport;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ITEM_UNCOUNTABLE_SUMMARY_REPORT".
 */
class ItemUncountableSummaryReport extends BaseItemUncountableSummaryReport
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
