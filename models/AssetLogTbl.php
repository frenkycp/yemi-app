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
    public $propose_scrap_dd, $upload_file;

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
                ['upload_file', 'file']
            ]
        );
    }

    public function getFixAsset()
    {
        return $this->hasOne(AssetTbl::className(), ['asset_id' => 'asset_id']);
    }
}
