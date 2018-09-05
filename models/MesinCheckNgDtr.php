<?php

namespace app\models;

use Yii;
use \app\models\base\MesinCheckNgDtr as BaseMesinCheckNgDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_CHECK_NG_DTR".
 */
class MesinCheckNgDtr extends BaseMesinCheckNgDtr
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'SEQ' => 'ID',
                'urutan' => 'Ticket No',
                'color_stat' => 'Status',
                'stat_last_update' => 'Last Update',
                'down_time' => 'Down Time',
                'stat_description' => 'Description',
            ]
        );
    }
}
