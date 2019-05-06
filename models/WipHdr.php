<?php

namespace app\models;

use Yii;
use \app\models\base\WipHdr as BaseWipHdr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_HDR".
 */
class WipHdr extends BaseWipHdr
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

    public function getWipDtr()
    {
        return $this->hasMany(WipDtr::className(), ['hdr_id_item' => 'hdr_id_item'])->all();
    }

    public function getDescription()
    {
        return $this->child . ' - ' . $this->child_desc;
    }
}
