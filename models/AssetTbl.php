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
    public $asset_name, $upload_file_proposal, $upload_file_bac, $upload_file_scraping;

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
                [['upload_file_proposal', 'upload_file_bac', 'upload_file_scraping'], 'file']
            ]
        );
    }

    public function getAssetName($value='')
    {
        return $this->asset_id . ' - ' . $this->computer_name;
    }
}
