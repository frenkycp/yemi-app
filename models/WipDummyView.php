<?php

namespace app\models;

use Yii;
use \app\models\base\WipDummyView as BaseWipDummyView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_DUMMY_VIEW".
 */
class WipDummyView extends BaseWipDummyView
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
