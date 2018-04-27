<?php

namespace app\models;

use Yii;
use \app\models\base\JobOrder as BaseJobOrder;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.JOB_ORDER".
 */
class JobOrderToday extends BaseJobOrder
{
    public $progress_bar;
    public $progress_badge;

    public static function tableName()
    {
        //return 'db_owner.JOB_ORDER_VIEW';
        return 'db_owner.JOB_ORDER_VIEW';
    }

    public function rules()
    {
        return [
            [['LOC_DESC', 'MODEL', 'DESTINATION'], 'string'],
            [['SCH_DATE'], 'safe'],
            [['ORDER_QTY', 'COMMIT_QTY', 'OPEN_QTY'], 'number']
        ];
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }
    
    /* public static function primaryKey()
    {
        return ['JOB_ORDER_NO'];
    } */

    public function attributeLabels()
    {
        return [
            'LOC_DESC' => 'Location',
            'SCH_DATE' => 'Sch  Date',
            'MODEL' => 'Model',
            'DESTINATION' => 'Destination',
            'ORDER_QTY' => 'Order  Qty',
            'COMMIT_QTY' => 'Commit  Qty',
            'OPEN_QTY' => 'Open  Qty',
        ];
    }

    /*public function rules()
    {
        return ArrayHelper::merge(
             parent::rules(),
             [
                  # custom validation rules
             ]
        );
    }*/
    
    public static function getDb()
    {
            return Yii::$app->get('db_sql_server');
    }
}
