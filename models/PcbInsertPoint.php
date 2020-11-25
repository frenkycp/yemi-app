<?php

namespace app\models;

use Yii;
use \app\models\base\PcbInsertPoint as BasePcbInsertPoint;
use yii\helpers\ArrayHelper;
use app\models\SapItemTbl;
use app\models\Karyawan;

/**
 * This is the model class for table "db_owner.PCB_INSERT_POINT".
 */
class PcbInsertPoint extends BasePcbInsertPoint
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'part_no' => 'Part No',
                'model_name' => 'Model Name',
                'pcb' => 'Pcb',
                'destination' => 'Destination',
                'smt_a' => 'SMT A',
                'smt_b' => 'SMT B',
                'smt' => 'SMT',
                'jv2' => 'JV2',
                'av131' => 'AV131',
                'rg131' => 'RG131',
                'ai' => 'AI',
                'mi' => 'MI',
                'total' => 'Total',
                'sap_bu' => 'BU',
                'price' => 'Price',
                'last_update' => 'Last Update',
            ]
        );
    }

    public function beforeSave($insert){
        date_default_timezone_set('Asia/Jakarta');
        if(parent::beforeSave($insert)){
            $this->smt = $this->smt_a + $this->smt_b;
            $this->ai = $this->jv2 + $this->av131 + $this->rg131;
            $this->total = $this->smt + $this->ai + $this->mi;
            $sap_item = SapItemTbl::find()->where(['material' => $this->part_no])->one();
            if ($sap_item) {
                $this->sap_bu = $sap_item->hpl_desc;
            }
            $created_karyawan = Karyawan::find()->where([
                'OR',
                ['NIK_SUN_FISH' => \Yii::$app->user->identity->username],
                ['NIK' => \Yii::$app->user->identity->username]
            ])->one();
            $this->update_by_id = $this->update_by_name = \Yii::$app->user->identity->username;
            if ($created_karyawan) {
                $this->update_by_name = $created_karyawan->NAMA_KARYAWAN;
            }
            $this->last_update = date('Y-m-d H:i:s');
            
            return true;
        }
    }
}
