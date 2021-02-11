<?php

namespace app\models;

use Yii;
use \app\models\base\TraceItemScrap as BaseTraceItemScrap;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TRACE_ITEM_SCRAP".
 */
class TraceItemScrap extends BaseTraceItemScrap
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'SERIAL_NO' => 'Serial No.',
                'ITEM' => 'Item',
                'ITEM_DESC' => 'Item Desc',
                'SUPPLIER' => 'Supplier',
                'SUPPLIER_DESC' => 'Supplier Name',
                'UM' => 'UM',
                'QTY' => 'Qty',
                'EXPIRED_DATE' => 'Expired Date',
                'LATEST_EXPIRED_DATE' => 'Request Expired Date (minimum)',
                'USER_ID' => 'Requestor ID',
                'USER_DESC' => 'Requestor Name',
                'USER_LAST_UPDATE' => 'Request Time',
                'STATUS' => 'Status',
                'CLOSE_BY_ID' => 'Close By ID',
                'CLOSE_BY_NAME' => 'Close By Name',
                'CLOSE_DATETIME' => 'Close Datetime',
                'REMARK' => 'Remark',
            ]
        );
    }
}
