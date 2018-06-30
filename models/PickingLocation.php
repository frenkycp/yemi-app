<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * summary
 */
class PickingLocation extends Model
{
    public $location;

    public function rules()
    {
        return [
            [['location'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'location' => 'Location',
        ];
    }
}