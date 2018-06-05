<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_unit".
 *
 * @property int $id
 * @property string $name
 * @property int $flag
 */
class ItemUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_unit';
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
