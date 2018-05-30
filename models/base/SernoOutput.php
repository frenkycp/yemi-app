<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tb_serno_output".
 *
 * @property string $pk
 * @property integer $id
 * @property string $stc
 * @property string $dst
 * @property integer $num
 * @property string $gmc
 * @property integer $qty
 * @property integer $output
 * @property integer $adv
 * @property string $etd
 * @property string $ship
 * @property integer $cntr
 * @property integer $ng
 * @property string $category
 * @property string $remark
 * @property string $aliasModel
 */
abstract class SernoOutput extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_serno_output';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mis7');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk'], 'required'],
            [['id', 'num', 'qty', 'output', 'adv', 'cntr', 'ng'], 'integer'],
            [['dst'], 'string'],
            [['etd', 'ship'], 'safe'],
            [['pk'], 'string', 'max' => 35],
            [['stc'], 'string', 'max' => 6],
            [['gmc'], 'string', 'max' => 7],
            [['category'], 'string', 'max' => 10],
            [['remark'], 'string', 'max' => 50],
            [['pk'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk' => 'Pk',
            'id' => 'ID',
            'stc' => 'Stc',
            'dst' => 'Dst',
            'num' => 'Num',
            'gmc' => 'Gmc',
            'qty' => 'Qty',
            'output' => 'Output',
            'adv' => 'Adv',
            'etd' => 'Etd',
            'ship' => 'Ship',
            'cntr' => 'Cntr',
            'ng' => 'Ng',
            'category' => 'Category',
            'remark' => 'Remark',
        ];
    }




}
