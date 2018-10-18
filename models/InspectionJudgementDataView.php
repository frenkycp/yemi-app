<?php

namespace app\models;

use Yii;
use \app\models\base\InspectionJudgementDataView as BaseInspectionJudgementDataView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "inspection_judgement_data_view".
 */
class InspectionJudgementDataView extends BaseInspectionJudgementDataView
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

    public function getPartName()
    {
        $sernoMaster = SernoMaster::find()->where(['gmc' => $this->gmc])->one();
        return $sernoMaster->model . ' // ' . $sernoMaster->color . ' // ' . $sernoMaster->dest;
    }
}
