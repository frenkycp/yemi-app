<?php

namespace app\models;

use Yii;
use \app\models\base\AssetLocTbl as BaseAssetLocTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ASSET_LOC_TBL".
 */
class AssetLocTbl extends BaseAssetLocTbl
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

    public function getFullDesc($value='')
    {
        // $loc_type = '';
        // if ($this->LOC_TYPE == 'I') {
        //     $loc_type = 'INTERNAL';
        // } elseif ($this->LOC_TYPE == 'L') {
        //     $loc_type = 'LOCAL';
        // } elseif ($this->LOC_TYPE == 'O') {
        //     $loc_type = 'OVERSEAS';
        // }

        if ($this->LOC_GROUP_DESC == null) {
            return $this->LOC_TYPE . ' | ' . $this->LOC_DESC . ' (' . $this->LOC . ')';
        } else {
            return $this->LOC_TYPE . ' | ' . $this->LOC_GROUP_DESC . ' - ' . $this->LOC_DESC . ' (' . $this->LOC . ')';
        }
        
    }
}
