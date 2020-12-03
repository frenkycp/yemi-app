<?php

namespace app\models;

use Yii;
use \app\models\base\SapMaterialDocumentBc as BaseSapMaterialDocumentBc;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SAP_MATERIAL_DOCUMENT_BC".
 */
class SapMaterialDocumentBc extends BaseSapMaterialDocumentBc
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
