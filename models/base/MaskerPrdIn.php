<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tbl_barang_incoming".
 *
 * @property integer $id_barang_incoming
 * @property string $datetime_incoming
 * @property string $part_no
 * @property string $part_name
 * @property string $category
 * @property double $plan
 * @property double $qty
 * @property string $exp_date
 * @property string $serno
 * @property string $aliasModel
 */
abstract class MaskerPrdIn extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_barang_incoming';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_cbsupplement');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime_incoming', 'part_no', 'part_name', 'category', 'plan', 'qty', 'serno'], 'required'],
            [['datetime_incoming', 'exp_date'], 'safe'],
            [['plan', 'qty'], 'number'],
            [['part_no', 'part_name', 'category', 'serno'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_barang_incoming' => 'Id Barang Incoming',
            'datetime_incoming' => 'Datetime Incoming',
            'part_no' => 'Part No',
            'part_name' => 'Part Name',
            'category' => 'Category',
            'plan' => 'Plan',
            'qty' => 'Qty',
            'exp_date' => 'Exp Date',
            'serno' => 'Serno',
        ];
    }




}
