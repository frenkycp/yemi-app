<?php

namespace app\models;

use Yii;
use \app\models\base\InjMachineTbl as BaseInjMachineTbl;
use yii\helpers\ArrayHelper;
use app\models\InjMoldingTbl;
use app\models\WipHdr;
use app\models\SapItemTbl;

/**
 * This is the model class for table "db_owner.INJ_MACHINE_TBL".
 */
class InjMachineTbl extends BaseInjMachineTbl
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

    public function beforeSave($insert){
        date_default_timezone_set('Asia/Jakarta');
        if(parent::beforeSave($insert)){
            if ($this->MOLDING_ID != '' && $this->MOLDING_ID != null) {
                $tmp_new_molding = InjMoldingTbl::findOne($this->MOLDING_ID);
                $tmp_new_molding->MACHINE_ID = $this->MACHINE_ID;
                $tmp_new_molding->MACHINE_DESC = $this->MACHINE_DESC;
                $tmp_new_molding->MOLDING_STATUS = 1;
                if (!$tmp_new_molding->save()) {
                    return json_encode($tmp_new_molding->errors);
                }

                $this->TOTAL_COUNT = $tmp_new_molding->TOTAL_COUNT;
                $this->MOLDING_NAME = $tmp_new_molding->MOLDING_NAME;
            } else {
                $this->MOLDING_ID = $this->MOLDING_NAME = null;
                $this->TOTAL_COUNT = 0;
            }
            if ($this->ITEM != '' && $this->ITEM != null) {
                $tmp_item = SapItemTbl::find()->where([
                    'material' => $this->ITEM
                ])->one();
                $this->ITEM_DESC = $tmp_item->material_description;
            } else {
                $this->ITEM = $this->ITEM_DESC = null;
            }
            return true;
        }
    }
}
