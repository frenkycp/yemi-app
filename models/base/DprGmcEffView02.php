<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "dpr_gmc_eff_view_02".
 *
 * @property integer $period
 * @property string $line
 * @property double $act_eff
 * @property double $plan_eff
 * @property string $aliasModel
 */
abstract class DprGmcEffView02 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dpr_gmc_eff_view_02';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mis7');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period'], 'integer'],
            [['line'], 'required'],
            [['act_eff', 'plan_eff'], 'number'],
            [['line'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period' => 'Period',
            'line' => 'Line',
            'act_eff' => 'Act Eff',
            'plan_eff' => 'Plan Eff',
        ];
    }




}