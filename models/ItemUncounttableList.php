<?php

namespace app\models;

use Yii;
use \app\models\base\ItemUncounttableList as BaseItemUncounttableList;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ITEM_UNCOUNTTABLE_LIST".
 */
class ItemUncounttableList extends BaseItemUncounttableList
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

    public function getFullDesc($value='')
    {
        return $this->ITEM . ' - ' . $this->ITEM_DESC;
    }
}
