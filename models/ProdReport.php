<?php

namespace app\models;

use Yii;
use \app\models\base\ProdReport as BaseProdReport;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.prod_report".
 */
class ProdReport extends BaseProdReport
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
	
    public static function getDb()
    {
            return Yii::$app->get('db_sql_server');
    }
}
