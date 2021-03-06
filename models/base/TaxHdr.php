<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.TAX_HDR".
 *
 * @property string $no_seri
 * @property string $no_seri_val
 * @property string $kdJenisTransaksi
 * @property string $fgPengganti
 * @property string $nomorFaktur
 * @property string $period
 * @property string $tanggalFaktur
 * @property string $npwpPenjual
 * @property string $namaPenjual
 * @property string $alamatPenjual
 * @property string $npwpLawanTransaksi
 * @property string $namaLawanTransaksi
 * @property string $alamatLawanTransaksi
 * @property double $jumlahDpp
 * @property double $jumlahPpn
 * @property double $jumlahPpnBm
 * @property string $statusApproval
 * @property string $statusFaktur
 * @property string $referensi
 * @property string $last_updated
 * @property string $status_upload
 * @property string $aliasModel
 */
abstract class TaxHdr extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.TAX_HDR';
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
            [['no_seri'], 'required'],
            [['tanggalFaktur', 'last_updated'], 'safe'],
            [['jumlahDpp', 'jumlahPpn', 'jumlahPpnBm'], 'number'],
            [['no_seri', 'no_seri_val', 'kdJenisTransaksi', 'fgPengganti', 'nomorFaktur', 'npwpPenjual', 'namaPenjual', 'alamatPenjual', 'npwpLawanTransaksi', 'namaLawanTransaksi', 'alamatLawanTransaksi', 'statusApproval', 'statusFaktur', 'referensi'], 'string', 'max' => 100],
            [['period'], 'string', 'max' => 6],
            [['status_upload'], 'string', 'max' => 1],
            [['no_seri'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_seri' => 'No Seri',
            'no_seri_val' => 'No Seri Val',
            'kdJenisTransaksi' => 'Kd Jenis Transaksi',
            'fgPengganti' => 'Fg Pengganti',
            'nomorFaktur' => 'Nomor Faktur',
            'period' => 'Period',
            'tanggalFaktur' => 'Tanggal Faktur',
            'npwpPenjual' => 'Npwp Penjual',
            'namaPenjual' => 'Nama Penjual',
            'alamatPenjual' => 'Alamat Penjual',
            'npwpLawanTransaksi' => 'Npwp Lawan Transaksi',
            'namaLawanTransaksi' => 'Nama Lawan Transaksi',
            'alamatLawanTransaksi' => 'Alamat Lawan Transaksi',
            'jumlahDpp' => 'Jumlah Dpp',
            'jumlahPpn' => 'Jumlah Ppn',
            'jumlahPpnBm' => 'Jumlah Ppn Bm',
            'statusApproval' => 'Status Approval',
            'statusFaktur' => 'Status Faktur',
            'referensi' => 'Referensi',
            'last_updated' => 'Last Updated',
            'status_upload' => 'Status Upload',
        ];
    }




}
