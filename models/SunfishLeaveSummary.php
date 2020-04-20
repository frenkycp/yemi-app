<?php

namespace app\models;

use Yii;
use \app\models\base\SunfishLeaveSummary as BaseSunfishLeaveSummary;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.VIEW_EMPGETLEAVEYEMI".
 */
class SunfishLeaveSummary extends BaseSunfishLeaveSummary
{
    public $valid_date, $name;

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

    public function getEmpData()
    {
        return $this->hasOne(SunfishViewEmp::className(), ['Emp_no' => 'emp_no']);
    }
}
