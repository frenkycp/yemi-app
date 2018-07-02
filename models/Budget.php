<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * summary
 */
class Budget extends Model
{
    public $budget_type;
    public $qty_or_amount;

    public function rules()
    {
        return [
            [['budget_type', 'qty_or_amount'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'budget_type' => 'Product Type',
            'qty_or_amount' => 'Filter',
        ];
    }
}