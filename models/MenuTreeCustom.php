<?php

namespace app\models;
 
use Yii;

/**
 * This is the model class for table "tbl_menu_tree".
 */
class MenuTreeCustom extends \kartik\tree\models\Tree
{
    public static function tableName()
    {
        return 'tbl_menu_tree';
    }   
}
