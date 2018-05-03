<?php

namespace app\models;

use Yii;
use \app\models\base\SernoOutput as BaseSernoOutput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_output".
 */
class SernoOutput extends BaseSernoOutput
{
    public $description;

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
    
    public function attributeLabels()
    {
        return [
            'pk' => 'Pk',
            'id' => 'ID',
            'stc' => 'Stc',
            'dst' => 'Destination',
            'num' => 'Num',
            'gmc' => 'GMC',
            'qty' => 'Plan',
            'output' => 'Actual',
            'adv' => 'Adv',
            'etd' => 'Etd',
            'cntr' => 'Cntr',
        ];
    }
    
    public static function getDb()
    {
            return Yii::$app->get('db_mis7');
    }
    
    public function getQtyBalance()
    {
        return $this->output - $this->qty;
    }

    public function getSernoMaster()
    {
        return $this->hasOne(SernoMaster::className(), ['gmc' => 'gmc']);
    }
}
