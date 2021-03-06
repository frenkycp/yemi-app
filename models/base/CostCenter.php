<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.COST_CENTER".
 *
 * @property string $CC_ID
 * @property string $CC_GROUP
 * @property string $CC_DESC
 * @property string $aliasModel
 */
abstract class CostCenter extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.COST_CENTER';
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
            [['CC_ID'], 'required'],
            [['CC_ID', 'CC_GROUP', 'CC_DESC'], 'string'],
            [['CC_ID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CC_ID' => 'Cc  ID',
            'CC_GROUP' => 'Cc  Group',
            'CC_DESC' => 'Cc  Desc',
        ];
    }




}
