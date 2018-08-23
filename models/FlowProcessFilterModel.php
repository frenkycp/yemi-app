<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * summary
 */
class FlowProcessFilterModel extends Model
{
    public $model;
    public $gmc;

    public function rules()
    {
        return [
            [['model', 'gmc'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'model' => 'Model',
            'gmc' => 'GMC',
        ];
    }
}