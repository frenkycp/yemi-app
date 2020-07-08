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
 * @property string $num
 * @property string $gmc
 * @property integer $qty
 * @property integer $output
 * @property integer $adv
 * @property integer $vanning
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
 * @property integer $cntr_old
 * @property string $gmc_desc
 * @property string $gmc_destination
 * @property string $bu
 * @property string $line
 * @property string $model
 * @property string $fg_kd
 * @property double $standard_price
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
            [['id', 'so', 'qty', 'output', 'adv', 'vanning', 'cntr', 'm3', 'back_order', 'cntr_old'], 'integer'],
            [['vms', 'etd', 'ship'], 'safe'],
            [['standard_price'], 'number'],
            [['pk', 'uniq', 'stc', 'dst', 'num', 'gmc', 'category', 'remark', 'invo', 'cont', 'etd_old', 'gmc_desc'], 'string', 'max' => 255],
            [['gmc_destination', 'bu', 'model'], 'string', 'max' => 50],
            [['line', 'fg_kd'], 'string', 'max' => 20],
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
            'vanning' => 'Vanning',
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
            'cntr_old' => 'Cntr Old',
            'gmc_desc' => 'Gmc Desc',
            'gmc_destination' => 'Gmc Destination',
            'bu' => 'Bu',
            'line' => 'Line',
            'model' => 'Model',
            'fg_kd' => 'Fg Kd',
            'standard_price' => 'Standard Price',
        ];
    }




}
