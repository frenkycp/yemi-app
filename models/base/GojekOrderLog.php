<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.GOJEK_ORDER_LOG".
 *
 * @property integer $log_id
 * @property integer $gojek_order_no
 * @property string $slip_id
 * @property string $item
 * @property string $item_desc
 * @property string $from_loc
 * @property string $to_loc
 * @property string $source
 * @property string $issued_date
 * @property string $GOJEK_ID
 * @property string $GOJEK_DESC
 * @property double $GOJEK_VALUE
 * @property string $NIK_REQUEST
 * @property string $NAMA_KARYAWAN
 * @property string $STAGE
 * @property string $LAST_UPDATE
 * @property string $BY_NAMA_KARYAWAN
 * @property string $aliasModel
 */
abstract class GojekOrderLog extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.GOJEK_ORDER_LOG';
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
            [['gojek_order_no'], 'required'],
            [['gojek_order_no'], 'integer'],
            [['slip_id', 'item', 'item_desc', 'from_loc', 'to_loc', 'source', 'GOJEK_ID', 'GOJEK_DESC', 'NIK_REQUEST', 'NAMA_KARYAWAN', 'STAGE', 'BY_NAMA_KARYAWAN'], 'string'],
            [['issued_date', 'LAST_UPDATE'], 'safe'],
            [['GOJEK_VALUE'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'gojek_order_no' => 'Gojek Order No',
            'slip_id' => 'Slip ID',
            'item' => 'Item',
            'item_desc' => 'Item Desc',
            'from_loc' => 'From Loc',
            'to_loc' => 'To Loc',
            'source' => 'Source',
            'issued_date' => 'Issued Date',
            'GOJEK_ID' => 'Gojek  ID',
            'GOJEK_DESC' => 'Gojek  Desc',
            'GOJEK_VALUE' => 'Gojek  Value',
            'NIK_REQUEST' => 'Nik  Request',
            'NAMA_KARYAWAN' => 'Nama  Karyawan',
            'STAGE' => 'Stage',
            'LAST_UPDATE' => 'Last  Update',
            'BY_NAMA_KARYAWAN' => 'By  Nama  Karyawan',
        ];
    }




}