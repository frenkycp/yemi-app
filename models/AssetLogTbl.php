<?php

namespace app\models;

use Yii;
use \app\models\base\AssetLogTbl as BaseAssetLogTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ASSET_LOG_TBL".
 */
class AssetLogTbl extends BaseAssetLogTbl
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
