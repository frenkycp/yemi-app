<?php

namespace app\models;

use Yii;
use \app\models\base\VmsRemark as BaseVmsRemark;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.VMS_REMARK".
 */
class VmsRemark extends BaseVmsRemark
{
    public $password;

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
