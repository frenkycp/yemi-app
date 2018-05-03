<?php

namespace app\models;

use Yii;
use \app\models\base\SernoMaster as BaseSernoMaster;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_master".
 */
class SernoMaster extends BaseSernoMaster
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
    
    public function getDescription()
    {
        return $this->model . ' // ' . $this->color . ' // ' . $this->dest;
    }
}
