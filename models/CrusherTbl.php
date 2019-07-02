<?php

namespace app\models;

use Yii;
use \app\models\base\CrusherTbl as BaseCrusherTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.CRUSHER_TBL".
 */
class CrusherTbl extends BaseCrusherTbl
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
                [['date', 'model', 'part', 'qty', 'bom', 'consume'], 'required'],
            ]
        );
    }
}
