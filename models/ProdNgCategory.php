<?php

namespace app\models;

use Yii;
use \app\models\base\ProdNgCategory as BaseProdNgCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_CATEGORY".
 */
class ProdNgCategory extends BaseProdNgCategory
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

    public function getDescription()
    {
        $description = $this->category_name . ' | ' . $this->category_detail;
        //return $this->model . ' // ' . $this->color . ' // ' . $this->dest;
        return $description;
    }
}
