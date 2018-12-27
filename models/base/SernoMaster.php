<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tb_serno_master".
 *
 * @property string $gmc
 * @property string $model
 * @property string $color
 * @property string $dest
 * @property string $package
 * @property integer $pallet
 * @property string $line
 * @property double $st
 * @property double $eff
 * @property string $aliasModel
 */
abstract class SernoMaster extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_serno_master';
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
            [['gmc'], 'required'],
            [['pallet'], 'integer'],
            [['st', 'eff'], 'number'],
            [['gmc'], 'string', 'max' => 11],
            [['model'], 'string', 'max' => 50],
            [['color'], 'string', 'max' => 2],
            [['dest'], 'string', 'max' => 3],
            [['package'], 'string', 'max' => 255],
            [['line'], 'string', 'max' => 30],
            [['gmc'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gmc' => 'Gmc',
            'model' => 'Model',
            'color' => 'Color',
            'dest' => 'Dest',
            'package' => 'Package',
            'pallet' => 'Pallet',
            'line' => 'Line',
            'st' => 'St',
            'eff' => 'Eff',
        ];
    }




}
