<?php

namespace app\models;

use Yii;
use \app\models\base\InjMoldingTbl as BaseInjMoldingTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.INJ_MOLDING_TBL".
 */
class InjMoldingTbl extends BaseInjMoldingTbl
{
    public $progress_pct;

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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'MOLDING_ID' => 'Molding ID',
                'MOLDING_NAME' => 'Molding Name',
                'MACHINE_ID' => 'Machine ID',
                'MACHINE_DESC' => 'Machine Desc',
                'TOTAL_COUNT' => 'Total Shots',
                'TARGET_COUNT' => 'Target Shots',
                'MOLDING_STATUS' => 'Molding Status',
                'LAST_UPDATE' => 'Last Update',
            ]
        );
    }
}
