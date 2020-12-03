<?php

namespace app\models;

use Yii;
use \app\models\base\SapGrGiByPlant as BaseSapGrGiByPlant;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SAP_GR_GI_BY_PLANT".
 */
class SapGrGiByPlant extends BaseSapGrGiByPlant
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
