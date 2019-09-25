<?php

namespace app\models;

use Yii;
use \app\models\base\HrFacility as BaseHrFacility;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.HR_FACILITY".
 */
class HrFacility extends BaseHrFacility
{
    public $img_01;
    const SCENARIO_CREATE = 'create';
    const SCENARIO_ANSWER = 'answer';
    
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
                [['img_01'], 'file'],
                [['remark', 'remark_category'], 'required', 'on' => self::SCENARIO_CREATE],
                [['response'], 'required', 'on' => self::SCENARIO_ANSWER],
            ]
        );
    }
}
