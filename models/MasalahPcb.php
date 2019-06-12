<?php

namespace app\models;

use Yii;
use \app\models\base\MasalahPcb as BaseMasalahPcb;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_masalah_pcb".
 */
class MasalahPcb extends BaseMasalahPcb
{
    public $period, $post_date, $total;

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
