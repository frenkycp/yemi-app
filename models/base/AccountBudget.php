<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.ACCOUNT_BUDGET".
 *
 * @property string $BUDGET_ID
 * @property string $ACCOUNT
 * @property string $ACCOUNT_DESC
 * @property string $DEP
 * @property string $DEP_DESC
 * @property integer $PERIOD
 * @property double $BUDGET_AMT
 * @property double $CONSUME_AMT
 * @property double $BALANCE_AMT
 * @property string $STATUS
 * @property string $CONTROL
 * @property string $aliasModel
 */
abstract class AccountBudget extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.ACCOUNT_BUDGET';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_wsus');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BUDGET_ID'], 'required'],
            [['BUDGET_ID', 'ACCOUNT', 'ACCOUNT_DESC', 'DEP', 'DEP_DESC', 'STATUS', 'CONTROL'], 'string'],
            [['PERIOD'], 'integer'],
            [['BUDGET_AMT', 'CONSUME_AMT', 'BALANCE_AMT'], 'number'],
            [['BUDGET_ID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BUDGET_ID' => 'Budget  ID',
            'ACCOUNT' => 'Account',
            'ACCOUNT_DESC' => 'Account  Desc',
            'DEP' => 'Dep',
            'DEP_DESC' => 'Dep  Desc',
            'PERIOD' => 'Period',
            'BUDGET_AMT' => 'Budget  Amt',
            'CONSUME_AMT' => 'Consume  Amt',
            'BALANCE_AMT' => 'Balance  Amt',
            'STATUS' => 'Status',
            'CONTROL' => 'Control',
        ];
    }




}