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
        return $this->LOC . ' | ' . $this->LOC_DESC;
    }
}
