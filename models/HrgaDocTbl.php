<?php

namespace app\models;

use Yii;
use \app\models\base\HrgaDocTbl as BaseHrgaDocTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.HRGA_DOC_TBL".
 */
class HrgaDocTbl extends BaseHrgaDocTbl
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
