<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * summary
 */
class WipFilterModel extends Model
{
    public $loc, $month, $year;

    public function rules()
    {
        return [
            [['loc'], 'string'],
            [['month', 'year'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'loc' => 'Location',
        ];
    }
}