<?php

namespace app\models;

use Yii;
use \app\models\base\SapItemTbl as BaseSapItemTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SAP_ITEM".
 */
class SapItemTbl extends BaseSapItemTbl
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

    public function getFullDescription()
    {
        return $this->material . ' - ' . $this->material_description;
    }
}
