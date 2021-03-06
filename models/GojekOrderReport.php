<?php

namespace app\models;

use Yii;
use \app\models\base\GojekOrderReport as BaseGojekOrderReport;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GOJEK_ORDER_REPORT".
 */
class GojekOrderReport extends BaseGojekOrderReport
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
