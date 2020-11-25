<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.PCB_INSERT_POINT_DATA".
 *
 * @property string $part_no
 * @property string $model_name
 * @property string $pcb
 * @property string $destination
 * @property integer $smt_a
 * @property integer $smt_b
 * @property integer $smt
 * @property integer $jv2
 * @property integer $rg131
 * @property integer $ai
 * @property integer $mi
 * @property integer $total
 * @property double $price
 * @property string $last_update
 * @property string $update_by_id
 * @property string $update_by_name
 * @property integer $flag
 * @property string $hpl_desc
 * @property string $bu
 * @property integer $av131
 * @property string $aliasModel
 */
abstract class PcbInsertPointData extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.PCB_INSERT_POINT_DATA';
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
            [['part_no'], 'required'],
            [['smt_a', 'smt_b', 'smt', 'jv2', 'rg131', 'ai', 'mi', 'total', 'flag', 'av131'], 'integer'],
            [['price'], 'number'],
            [['last_update'], 'safe'],
            [['part_no', 'model_name', 'pcb', 'destination', 'update_by_id', 'hpl_desc', 'bu'], 'string', 'max' => 50],
            [['update_by_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'part_no' => 'Part No',
            'model_name' => 'Model Name',
            'pcb' => 'Pcb',
            'destination' => 'Destination',
            'smt_a' => 'Smt A',
            'smt_b' => 'Smt B',
            'smt' => 'Smt',
            'jv2' => 'Jv2',
            'rg131' => 'Rg131',
            'ai' => 'Ai',
            'mi' => 'Mi',
            'total' => 'Total',
            'price' => 'Price',
            'last_update' => 'Last Update',
            'update_by_id' => 'Update By ID',
            'update_by_name' => 'Update By Name',
            'flag' => 'Flag',
            'hpl_desc' => 'Hpl Desc',
            'bu' => 'Bu',
            'av131' => 'Av131',
        ];
    }




}
