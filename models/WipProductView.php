<?php

namespace app\models;

use Yii;
use \app\models\base\WipProductView as BaseWipProductView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_PRODUCT_VIEW".
 */
class WipProductView extends BaseWipProductView
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
