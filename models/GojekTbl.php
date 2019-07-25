<?php

namespace app\models;

use Yii;
use \app\models\base\GojekTbl as BaseGojekTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GOJEK_TBL".
 */
class GojekTbl extends BaseGojekTbl
{
    public $stat_open, $stat_close, $stat_total, $JOB_COUNT, $TOTAL_LT;

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

    public function getGojekOrderTbl()
    {
        return $this->hasMany(GojekOrderTbl::className(), ['GOJEK_ID' => 'GOJEK_ID']);
    }

    public function getGojekView02()
    {
        return $this->hasMany(GojekView02::className(), ['GOJEK_ID' => 'GOJEK_ID']);
    }

    public function getNikName($value='')
    {
        return $this->GOJEK_ID . ' - ' . $this->GOJEK_DESC;
    }
}
