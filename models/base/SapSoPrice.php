<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SAP_SO_PRICE".
 *
 * @property string $so_no_material_number
 * @property string $so_no
 * @property string $material_number
 * @property string $currency
 * @property string $price_master
 * @property integer $period_plan
 * @property string $period_plan_rate_id
 * @property double $period_plan_rate
 * @property double $price_master_usd
 * @property string $aliasModel
 */
abstract class SapSoPrice extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SAP_SO_PRICE';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sql_server');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['so_no_material_number'], 'required'],
            [['period_plan'], 'integer'],
            [['period_plan_rate', 'price_master_usd'], 'number'],
            [['so_no_material_number'], 'string', 'max' => 100],
            [['so_no', 'material_number', 'currency', 'price_master', 'period_plan_rate_id'], 'string', 'max' => 50],
            [['so_no_material_number'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'so_no_material_number' => 'So No Material Number',
            'so_no' => 'So No',
            'material_number' => 'Material Number',
            'currency' => 'Currency',
            'price_master' => 'Price Master',
            'period_plan' => 'Period Plan',
            'period_plan_rate_id' => 'Period Plan Rate ID',
            'period_plan_rate' => 'Period Plan Rate',
            'price_master_usd' => 'Price Master Usd',
        ];
    }




}
