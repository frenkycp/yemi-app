<?php

namespace app\models;

use Yii;
use \app\models\base\MntCorrectiveView as BaseMntCorrectiveView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MNT_CORRECTIVE_VIEW".
 */
class MntCorrectiveView extends BaseMntCorrectiveView
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
