<?php

namespace app\models;

use Yii;
use \app\models\base\AssetStockTakeSummary as BaseAssetStockTakeSummary;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ASSET_STOCK_TAKE_SUMMARY".
 */
class AssetStockTakeSummary extends BaseAssetStockTakeSummary
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
