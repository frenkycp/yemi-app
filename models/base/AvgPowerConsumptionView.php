<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.AVG_POWER_CONSUMPTION_VIEW".
 *
 * @property string $post_date
 * @property double $map_no
 * @property string $Factory
 * @property string $location
 * @property string $area
 * @property double $avg_power_consumption
 * @property string $aliasModel
 */
abstract class AvgPowerConsumptionView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.AVG_POWER_CONSUMPTION_VIEW';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sql_server');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_no', 'avg_power_consumption'], 'number'],
            [['post_date'], 'string', 'max' => 4000],
            [['Factory', 'location', 'area'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_date' => 'Post Date',
            'map_no' => 'Map No',
            'Factory' => 'Factory',
            'location' => 'Location',
            'area' => 'Area',
            'avg_power_consumption' => 'Avg Power Consumption',
        ];
    }




}
