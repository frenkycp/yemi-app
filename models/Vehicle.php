<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle".
 *
 * @property int $id
 * @property string $name
 * @property int $flag
 */
class Vehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag'], 'integer'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'flag' => 'Flag',
        ];
    }

    public static function getDb()
    {
            return Yii::$app->get('db_wh_app');
    }
}
