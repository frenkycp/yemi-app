<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tb_serno_output".
 *
 * @property string $pk
 * @property string $uniq
 * @property integer $id
 * @property integer $so
 * @property string $stc
 * @property string $dst
 * @property integer $num
 * @property string $gmc
 * @property integer $qty
 * @property integer $output
 * @property integer $adv
 * @property string $vms
 * @property string $etd
 * @property string $ship
 * @property integer $cntr
 * @property string $category
 * @property string $remark
 * @property string $invo
 * @property string $cont
 * @property integer $m3
 * @property integer $back_order
 * @property string $etd_old
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
            [['pk', 'uniq', 'stc', 'dst', 'gmc', 'vms', 'etd', 'ship'], 'required'],
            [['id', 'so', 'num', 'qty', 'output', 'adv', 'cntr', 'm3', 'back_order'], 'integer'],
            [['vms', 'etd', 'ship'], 'safe'],
            [['pk'], 'string', 'max' => 35],
            [['uniq'], 'string', 'max' => 25],
            [['stc', 'gmc'], 'string', 'max' => 7],
            [['dst', 'remark'], 'string', 'max' => 50],
            [['category', 'etd_old'], 'string', 'max' => 10],
            [['invo', 'cont'], 'string', 'max' => 30],
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
            'uniq' => 'Uniq',
            'id' => 'ID',
            'so' => 'So',
            'stc' => 'Stc',
            'dst' => 'Dst',
            'num' => 'Num',
            'gmc' => 'Gmc',
            'qty' => 'Qty',
            'output' => 'Output',
            'adv' => 'Adv',
            'vms' => 'Vms',
            'etd' => 'Etd',
            'ship' => 'Ship',
            'cntr' => 'Cntr',
            'category' => 'Category',
            'remark' => 'Remark',
            'invo' => 'Invo',
            'cont' => 'Cont',
            'm3' => 'M3',
            'back_order' => 'Back Order',
            'etd_old' => 'Etd Old',
        ];
    }




}
