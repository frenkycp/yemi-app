<?php

namespace app\models;

use Yii;
use \app\models\base\IpqaPatrolOutstandingView as BaseIpqaPatrolOutstandingView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.IPQA_PATROL_OUTSTANDING_VIEW".
 */
class IpqaPatrolOutstandingView extends BaseIpqaPatrolOutstandingView
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
