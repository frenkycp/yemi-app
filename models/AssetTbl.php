<?php

namespace app\models;

use Yii;
use \app\models\base\AssetTbl as BaseAssetTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ASSET_TBL".
 */
class AssetTbl extends BaseAssetTbl
{
    public $asset_name;

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
        return $this->asset_id . ' - ' . $this->computer_name;
    }
}
