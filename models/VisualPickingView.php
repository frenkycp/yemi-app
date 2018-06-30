<?php

namespace app\models;

use Yii;
use \app\models\base\VisualPickingView as BaseVisualPickingView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.VISUAL_PICKING_VIEW".
 */
class VisualPickingView extends BaseVisualPickingView
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
