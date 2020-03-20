<?php

namespace app\models;

use Yii;
use \app\models\base\ProdNgPositionView as BaseProdNgPositionView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_POSITION_VIEW".
 */
class ProdNgPositionView extends BaseProdNgPositionView
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
        if ($this->position == '' || $this->position == null) {
            return $this->ng_loc_id . ' | ' . $this->category_detail;
        } else {
            return $this->ng_loc_id . ' | ' . $this->position;
        }
        
    }
}
