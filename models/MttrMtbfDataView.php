<?php

namespace app\models;

use Yii;
use \app\models\base\MttrMtbfDataView as BaseMttrMtbfDataView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MTTR_MTBF_DATA_VIEW".
 */
class MttrMtbfDataView extends BaseMttrMtbfDataView
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
