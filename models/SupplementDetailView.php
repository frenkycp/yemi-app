<?php

namespace app\models;

use Yii;
use \app\models\base\SupplementDetailView as BaseSupplementDetailView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "supplement_detail_view".
 */
class SupplementDetailView extends BaseSupplementDetailView
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
}
