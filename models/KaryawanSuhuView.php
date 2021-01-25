<?php

namespace app\models;

use Yii;
use \app\models\base\KaryawanSuhuView as BaseKaryawanSuhuView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.karyawan_suhu_view".
 */
class KaryawanSuhuView extends BaseKaryawanSuhuView
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
