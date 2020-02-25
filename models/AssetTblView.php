<?php

namespace app\models;

use Yii;
use \app\models\base\AssetTblView as BaseAssetTblView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ASSET_TBL_VIEW".
 */
class AssetTblView extends BaseAssetTblView
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
