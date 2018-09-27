<?php

namespace app\models;

use Yii;
use \app\models\base\PrReportView as BasePrReportView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PR_REPORT_VIEW".
 */
class PrReportView extends BasePrReportView
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
