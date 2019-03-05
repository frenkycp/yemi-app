<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * summary
 */
class WipFilterModel extends Model
{
    public $loc, $month, $year, $category, $line;

    public function rules()
    {
        return [
            [['loc', 'line'], 'string'],
            [['month', 'year', 'category'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'loc' => 'Location',
        ];
    }
}