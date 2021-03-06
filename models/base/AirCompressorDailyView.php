<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.AIR_COMPRESSOR_DAILY_VIEW".
 *
 * @property double $map_no
 * @property string $area
 * @property string $post_date
 * @property double $running_hour
 * @property string $aliasModel
 */
abstract class AirCompressorDailyView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.AIR_COMPRESSOR_DAILY_VIEW';
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
            [['map_no', 'running_hour'], 'number'],
            [['area'], 'string', 'max' => 100],
            [['post_date'], 'string', 'max' => 4000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'map_no' => 'Map No',
            'area' => 'Area',
            'post_date' => 'Post Date',
            'running_hour' => 'Running Hour',
        ];
    }




}
