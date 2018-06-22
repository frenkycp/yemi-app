<?php

namespace app\models;

use Yii;
use \app\models\base\SernoInput as BaseSernoInput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_input".
 */
class SernoInput extends BaseSernoInput
{
    public $etd_ship, $destination, $week_no, $total;

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

    public static function getDb()
    {
        return Yii::$app->get('db_mis7');
    }

    public function getSernoOutput()
    {
        return $this->hasOne(SernoOutput::className(), ['pk' => 'plan']);
    }

    public function getSernoMaster()
    {
        return $this->hasOne(SernoMaster::className(), ['gmc' => 'gmc']);
    }

    public function getPartName()
    {
        $sernoMaster = SernoMaster::find()->where(['gmc' => $this->gmc])->one();
        return $sernoMaster->model . ' // ' . $sernoMaster->color . ' // ' . $sernoMaster->dest;
    }
}
