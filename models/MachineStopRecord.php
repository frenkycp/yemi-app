<?php

namespace app\models;

use Yii;
use \app\models\base\MachineStopRecord as BaseMachineStopRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_STOP_RECORD".
 */
class MachineStopRecord extends BaseMachineStopRecord
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
                [['MESIN_ID'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'MESIN_ID' => 'Machine',
                'MESIN_DESC' => 'Machine Name',
            ]
        );
    }
}
