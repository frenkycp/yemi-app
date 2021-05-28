<?php

namespace app\models;

use Yii;
use \app\models\base\TreeAccDigilib as BaseTreeAccDigilib;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tree_acc_digilib".
 */
class TreeAccDigilib extends BaseTreeAccDigilib
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
