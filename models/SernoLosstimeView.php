<?php

namespace app\models;

use Yii;
use \app\models\base\SernoLosstimeView as BaseSernoLosstimeView;
use yii\helpers\ArrayHelper;
use app\models\SernoMaster;

/**
 * This is the model class for table "serno_losstime_view".
 */
class SernoLosstimeView extends BaseSernoLosstimeView
{
    public $description, $losstime_each;

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

    public function getPartName()
    {
        $sernoMaster = SernoMaster::find()->where(['gmc' => $this->model])->one();
        if ($sernoMaster->gmc == null) {
            return '-';
        }
        return $sernoMaster->model . ' // ' . $sernoMaster->color . ' // ' . $sernoMaster->dest;
    }
}
