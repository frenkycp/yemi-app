<?php

namespace app\models;

use Yii;
use \app\models\base\SplView as BaseSplView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SPL_VIEW".
 */
class SplView extends BaseSplView
{
    public $JUMLAH, $total_lembur, $min_year, $NILAI_LEMBUR_ACTUAL_EXPORT;
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
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'NIK' => 'NIK',
                'CC_GROUP' => 'Departemen',
            ]
        );
    }
}
