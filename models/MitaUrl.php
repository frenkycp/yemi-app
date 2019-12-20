<?php

namespace app\models;

use Yii;
use \app\models\base\MitaUrl as BaseMitaUrl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MITA_URL".
 */
class MitaUrl extends BaseMitaUrl
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
