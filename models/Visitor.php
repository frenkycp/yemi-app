<?php

namespace app\models;

use Yii;
use \app\models\base\Visitor as BaseVisitor;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_visitor".
 */
class Visitor extends BaseVisitor
{
    public $id_name;

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
