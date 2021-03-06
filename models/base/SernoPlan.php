<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tb_serno_plan".
 *
 * @property string $pk_plan
 * @property integer $num_plan
 * @property string $gmc_plan
 * @property integer $qty_plan
 * @property string $date_plan
 * @property string $week_plan
 * @property string $desc_plan
 * @property string $uniq_plan
 * @property integer $output_plan
 * @property string $aliasModel
 */
abstract class SernoPlan extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_serno_plan';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk_plan', 'week_plan'], 'required'],
            [['num_plan', 'qty_plan', 'output_plan'], 'integer'],
            [['pk_plan'], 'string', 'max' => 20],
            [['gmc_plan', 'uniq_plan'], 'string', 'max' => 7],
            [['date_plan'], 'string', 'max' => 10],
            [['week_plan', 'desc_plan'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_plan' => 'Pk Plan',
            'num_plan' => 'Num Plan',
            'gmc_plan' => 'Gmc Plan',
            'qty_plan' => 'Qty Plan',
            'date_plan' => 'Date Plan',
            'week_plan' => 'Week Plan',
            'desc_plan' => 'Desc Plan',
            'uniq_plan' => 'Uniq Plan',
            'output_plan' => 'Output Plan',
        ];
    }




}
