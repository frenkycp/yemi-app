<?php

namespace app\models;

use Yii;
use \app\models\base\AssetLogView as BaseAssetLogView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ASSET_LOG_VIEW".
 */
class AssetLogView extends BaseAssetLogView
{
    public $total_open, $total_close, $total, $asset_img, $signature;

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
