<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.TAX_DTR".
 *
 * @property string $dtrid
 * @property string $no_seri
 * @property string $no
 * @property string $nama
 * @property double $hargaSatuan
 * @property double $jumlahBarang
 * @property double $hargaTotal
 * @property double $diskon
 * @property double $dpp
 * @property double $ppn
 * @property double $tarifPpnbm
 * @property double $ppnbm
 * @property string $aliasModel
 */
abstract class TaxDtr extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.TAX_DTR';
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
            [['dtrid', 'no_seri'], 'required'],
            [['hargaSatuan', 'jumlahBarang', 'hargaTotal', 'diskon', 'dpp', 'ppn', 'tarifPpnbm', 'ppnbm'], 'number'],
            [['dtrid'], 'string', 'max' => 50],
            [['no_seri', 'nama'], 'string', 'max' => 100],
            [['no'], 'string', 'max' => 3],
            [['dtrid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dtrid' => 'Dtrid',
            'no_seri' => 'No Seri',
            'no' => 'No',
            'nama' => 'Nama',
            'hargaSatuan' => 'Harga Satuan',
            'jumlahBarang' => 'Jumlah Barang',
            'hargaTotal' => 'Harga Total',
            'diskon' => 'Diskon',
            'dpp' => 'Dpp',
            'ppn' => 'Ppn',
            'tarifPpnbm' => 'Tarif Ppnbm',
            'ppnbm' => 'Ppnbm',
        ];
    }




}
