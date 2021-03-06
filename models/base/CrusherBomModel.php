<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.CRUSHER_BOM_MODEL".
 *
 * @property integer $id
 * @property string $model_name
 * @property string $part_type
 * @property double $bom_qty
 * @property string $aliasModel
 */
abstract class CrusherBomModel extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.CRUSHER_BOM_MODEL';
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
            [['model_name', 'part_type'], 'string'],
            [['bom_qty'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_name' => 'Model Name',
            'part_type' => 'Part Type',
            'bom_qty' => 'Bom Qty',
        ];
    }




}
