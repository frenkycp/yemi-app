<?php

namespace app\models;

use Yii;
use \app\models\base\Menu as BaseMenu;

/**
 * This is the model class for table "menu".
 */
class Menu extends BaseMenu
{
	public function rules()
    {
        return [
            [['name', 'icon'], 'required'],
            [['order', 'parent_id'], 'integer'],
            [['name', 'controller', 'action', 'icon'], 'string', 'max' => 50]
        ];
    }
}
