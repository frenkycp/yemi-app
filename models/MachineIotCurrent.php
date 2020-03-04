<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotCurrent as BaseMachineIotCurrent;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_CURRENT".
 */
class MachineIotCurrent extends BaseMachineIotCurrent
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

    public function getAssetName($value='')
    {
        return $this->kelompok . ' - ' . $this->mesin_description . "($this->mesin_id)";
    }

    public function getLocation($value='')
    {
        $loc_arr = \Yii::$app->params['wip_location_arr'];
        return $loc_arr[$this->child_analyst];
    }
}
