<?php

namespace app\models;

use Yii;
use \app\models\base\ServerBackupCurrent as BaseServerBackupCurrent;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SERVER_BACK_UP_CUR".
 */
class ServerBackupCurrent extends BaseServerBackupCurrent
{
    public $total;

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
