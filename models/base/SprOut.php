<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "spr_out".
 *
 * @property integer $id_sprout
 * @property string $lot_sprout
 * @property string $date_sprout
 * @property string $line_sprout
 * @property string $part_sprout
 * @property integer $qty_sprout
 * @property string $aliasModel
 */
abstract class SprOut extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'spr_out';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_spr');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lot_sprout', 'date_sprout', 'line_sprout', 'part_sprout', 'qty_sprout'], 'required'],
            [['date_sprout'], 'safe'],
            [['qty_sprout'], 'integer'],
            [['lot_sprout', 'line_sprout', 'part_sprout'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sprout' => 'Id Sprout',
            'lot_sprout' => 'Lot Sprout',
            'date_sprout' => 'Date Sprout',
            'line_sprout' => 'Line Sprout',
            'part_sprout' => 'Part Sprout',
            'qty_sprout' => 'Qty Sprout',
        ];
    }




}
