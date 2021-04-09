<?php

namespace app\models;

use Yii;
use \app\models\base\ScrapSummaryView02 as BaseScrapSummaryView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SCRAP_SUMMARY_VIEW_02".
 */
class ScrapSummaryView02 extends BaseScrapSummaryView02
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
