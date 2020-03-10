<?php

namespace app\models;

use Yii;
use \app\models\base\AssetStockTakeScheduleView as BaseAssetStockTakeScheduleView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ASSET_STOCK_TAKE_SCHEDULE_VIEW".
 */
class AssetStockTakeScheduleView extends BaseAssetStockTakeScheduleView
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

    public function getPeriod($value='')
    {
        return date('d M\' Y', strtotime($this->start_date)) . ' - ' . date('d M\' Y', strtotime($this->end_date));
    }
}
