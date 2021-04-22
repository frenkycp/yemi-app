<?php

namespace app\models;

use Yii;
use \app\models\base\KlinikObatLog as BaseKlinikObatLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_klinik_obat_log".
 */
class KlinikObatLog extends BaseKlinikObatLog
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
