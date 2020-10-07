<?php

namespace app\models;

use Yii;
use \app\models\base\DbSmtMaterialInOut as BaseDbSmtMaterialInOut;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_material_in_out".
 */
class DbSmtMaterialInOut extends BaseDbSmtMaterialInOut
{
    public $post_date, $total_count;

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
