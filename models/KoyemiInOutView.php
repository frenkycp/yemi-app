<?php

namespace app\models;

use Yii;
use \app\models\base\KoyemiInOutView as BaseKoyemiInOutView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.KOYEMI_IN_OUT_VIEW".
 */
class KoyemiInOutView extends BaseKoyemiInOutView
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
