<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.MACHINE_IOT_CURRENT".
 *
 * @property string $mesin_id
 * @property string $mesin_description
 * @property string $status_warna
 * @property string $system_date_time
 * @property string $kelompok
 * @property string $lot_number
 * @property string $gmc
 * @property string $gmc_desc
 * @property double $lot_qty
 * @property string $product_name
 * @property string $aliasModel
 */
abstract class ServerMachineIotCurrent extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.MACHINE_IOT_CURRENT';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_iot');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mesin_id'], 'required'],
            [['mesin_id', 'mesin_description', 'status_warna', 'kelompok', 'lot_number', 'gmc', 'gmc_desc', 'product_name'], 'string'],
            [['system_date_time'], 'safe'],
            [['lot_qty'], 'number'],
            [['mesin_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mesin_id' => 'Mesin ID',
            'mesin_description' => 'Mesin Description',
            'status_warna' => 'Status Warna',
            'system_date_time' => 'System Date Time',
            'kelompok' => 'Kelompok',
            'lot_number' => 'Lot Number',
            'gmc' => 'Gmc',
            'gmc_desc' => 'Gmc Desc',
            'lot_qty' => 'Lot Qty',
            'product_name' => 'Product Name',
        ];
    }




}
