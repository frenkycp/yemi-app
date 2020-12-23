<?php

namespace app\models;

use Yii;
use \app\models\base\ProdNgDetailSerno as BaseProdNgDetailSerno;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_DETAIL_SERNO".
 */
class ProdNgDetailSerno extends BaseProdNgDetailSerno
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
                [['serial_no', 'repair_id'], 'required'],
            ]
        );
    }
}
