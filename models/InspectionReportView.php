<?php

namespace app\models;

use Yii;
use \app\models\base\InspectionReportView as BaseInspectionReportView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "inspection_report_view".
 */
class InspectionReportView extends BaseInspectionReportView
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
