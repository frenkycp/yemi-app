<?php

namespace app\models;

use Yii;
use \app\models\base\DbSmtReelInOut as BaseDbSmtReelInOut;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_reel_in_out".
 */
class DbSmtReelInOut extends BaseDbSmtReelInOut
{
    public $post_date, $total_count;
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
