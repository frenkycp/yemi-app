<?php

namespace app\models;

use Yii;
use \app\models\base\ClientStatus as BaseClientStatus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.CLIENT_STATUS".
 */
class ClientStatus extends BaseClientStatus
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
