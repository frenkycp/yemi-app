<?php

namespace app\models;

use Yii;
use \app\models\base\ScrapSummaryView01 as BaseScrapSummaryView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SCRAP_SUMMARY_VIEW_01".
 */
class ScrapSummaryView01 extends BaseScrapSummaryView01
{
    public $in_qty, $in_amt, $out_qty, $out_amt, $balance_qty, $balance_amt;

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
