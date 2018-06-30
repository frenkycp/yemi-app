<?php

namespace app\models;

use Yii;
use \app\models\base\VisualPickingView02 as BaseVisualPickingView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.VISUAL_PICKING_VIEW_02".
 */
class VisualPickingView02 extends BaseVisualPickingView02
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
