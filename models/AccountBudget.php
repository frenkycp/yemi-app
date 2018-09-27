<?php

namespace app\models;

use Yii;
use \app\models\base\AccountBudget as BaseAccountBudget;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ACCOUNT_BUDGET".
 */
class AccountBudget extends BaseAccountBudget
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

    public function getPrReportView()
    {
        return $this->hasMany(PrReportView::className(), ['BUDGET_ID' => 'BUDGET_ID']);
    }
}
