<?php

namespace app\models;

use Yii;
use \app\models\base\AssetDtrTbl as BaseAssetDtrTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ASSET_DTR_TBL".
 */
class AssetDtrTbl extends BaseAssetDtrTbl
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
