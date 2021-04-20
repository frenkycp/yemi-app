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
                'LAST_UPDATE' => 'Last Count',
                'SHOT_PCT' => 'Shot(%)',
            ]
        );
    }

    public function getFullDesc()
    {
        return $this->MOLDING_ID . ' - ' . $this->MOLDING_NAME;
    }

    public function beforeSave($insert){
        date_default_timezone_set('Asia/Jakarta');
        if(parent::beforeSave($insert)){
            if ($this->TARGET_COUNT > 0) {
                $this->SHOT_PCT = round(($this->TOTAL_COUNT / $this->TARGET_COUNT) * 100, 1);
            } else {
                $this->SHOT_PCT = 0;
            }
            
            return true;
        }
    }
}
