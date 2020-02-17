<?php

namespace app\models;

use Yii;
use \app\models\base\LiveCookingRequest as BaseLiveCookingRequest;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.LIVE_COOKING_REQUEST".
 */
class LiveCookingRequest extends BaseLiveCookingRequest
{
    public $from_date, $to_date, $employee, $order_status;

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
                [['post_date', 'cc', 'employee'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                'SEQ' => 'Seq',
                'NIK_AND_DATE' => 'Nik  And  Date',
                'NIK' => 'Nik',
                'NAMA_KARYAWAN' => 'Nama  Karyawan',
                'post_date' => 'Date',
                'qty_request' => 'Qty Request',
                'qty_actual' => 'Qty Actual',
                'qty_diff' => 'Qty Diff',
                'close_open' => 'Close Open',
                'close_open_note' => 'Close Open Note',
                'USER_CLOSE' => 'User  Close',
                'USER_DESC_CLOSE' => 'User  Desc  Close',
                'USER_LAST_UPDATE_CLOSE' => 'User  Last  Update  Close',
                'id' => 'ID',
                'cc' => 'Department/Section',
                'cc_desc' => 'Cc Desc',
                'type' => 'Type',
                'week_no' => 'Week No',
                'start_date' => 'Start Date',
                'end_date' => 'End Date',
                'USER_ID' => 'User  ID',
                'USER_DESC' => 'User  Desc',
                'USER_LAST_UPDATE' => 'User  Last  Update',
            ]
        );
    }
}
