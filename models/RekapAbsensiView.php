<?php

namespace app\models;

use Yii;
use \app\models\base\RekapAbsensiView as BaseRekapAbsensiView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.REKAP_ABSENSI_VIEW".
 */
class RekapAbsensiView extends BaseRekapAbsensiView
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
