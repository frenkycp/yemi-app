<?php

namespace app\models;

use Yii;
use \app\models\base\IpqaPatrolTbl as BaseIpqaPatrolTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.IPQA_PATROL_TBL".
 */
class IpqaPatrolTbl extends BaseIpqaPatrolTbl
{
    public $upload_file1;

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
                [['event_date', 'gmc', 'category', 'description', 'line_pic'], 'required'],
                [['upload_file1'], 'file'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'gmc' => 'GMC',
                'event_date' => 'Date',
                'destination' => 'Dest.',
                'input_datetime' => 'Input Time',
                'close_datetime' => 'Close Time',
            ]
        );
    }

    public function getCostCenter()
    {
        return $this->hasOne(CostCenter::className(), ['CC_ID' => 'CC_ID'])->one();
    }
}
