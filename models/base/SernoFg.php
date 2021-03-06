<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tb_serno_fg".
 *
 * @property string $pk_cont
 * @property string $tgl_cont
 * @property integer $no_cont
 * @property string $no_invoice
 * @property string $gmc
 * @property integer $no_pack
 * @property string $unit_pack
 * @property integer $qty
 * @property string $unit
 * @property string $id_cont
 * @property string $shipto
 * @property string $aliasModel
 */
abstract class SernoFg extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_serno_fg';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk_cont'], 'required'],
            [['no_cont', 'no_pack', 'qty'], 'integer'],
            [['pk_cont'], 'string', 'max' => 12],
            [['tgl_cont'], 'string', 'max' => 10],
            [['no_invoice'], 'string', 'max' => 6],
            [['gmc'], 'string', 'max' => 7],
            [['unit_pack', 'unit'], 'string', 'max' => 3],
            [['id_cont'], 'string', 'max' => 25],
            [['shipto'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk_cont' => 'Pk Cont',
            'tgl_cont' => 'Tgl Cont',
            'no_cont' => 'No Cont',
            'no_invoice' => 'No Invoice',
            'gmc' => 'Gmc',
            'no_pack' => 'No Pack',
            'unit_pack' => 'Unit Pack',
            'qty' => 'Qty',
            'unit' => 'Unit',
            'id_cont' => 'Id Cont',
            'shipto' => 'Shipto',
        ];
    }




}
