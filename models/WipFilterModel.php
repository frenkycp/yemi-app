<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * summary
 */
class WipFilterModel extends Model
{
    public $loc, $month, $year, $category;

    public function rules()
    {
        return [
            [['loc'], 'string'],
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