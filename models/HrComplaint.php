<?php

namespace app\models;

use Yii;
use \app\models\base\HrComplaint as BaseHrComplaint;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.HR_COMPLAINT".
 */
class HrComplaint extends BaseHrComplaint
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
