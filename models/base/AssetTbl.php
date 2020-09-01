<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.ASSET_TBL".
 *
 * @property string $asset_id
 * @property string $qr
 * @property string $ip_address
 * @property string $computer_name
 * @property string $jenis
 * @property string $manufacture
 * @property string $manufacture_desc
 * @property string $cpu_desc
 * @property string $ram_desc
 * @property string $rom_desc
 * @property string $os_desc
 * @property string $fixed_asst_account
 * @property string $asset_category
 * @property string $purchase_date
 * @property integer $report_type
 * @property string $LAST_UPDATE
 * @property string $network
 * @property string $display
 * @property string $camera
 * @property string $battery
 * @property string $note
 * @property string $loc_type
 * @property string $LOC
 * @property string $location
 * @property string $area
 * @property string $project
 * @property string $cur
 * @property double $price
 * @property double $price_usd
 * @property string $manager_name
 * @property string $department_pic
 * @property string $cost_centre
 * @property string $department_name
 * @property string $section_name
 * @property string $nik
 * @property string $NAMA_KARYAWAN
 * @property string $primary_picture
 * @property string $FINANCE_ASSET
 * @property double $qty
 * @property double $AtCost
 * @property string $Discontinue
 * @property string $DateDisc
 * @property string $scrap_slip_no
 * @property string $scrap_by_id
 * @property string $scrap_by_name
 * @property string $scrap_pic_id
 * @property string $scrap_pic_name
 * @property string $scrap_proposal_file
 * @property string $bac_file
 * @property string $scraping_file
 * @property string $status
 * @property string $label
 * @property double $NBV
 * @property string $propose_scrap
 * @property string $expired_date
 * @property string $img_filename
 * @property string $model_used
 * @property string $part
 * @property string $domestic_overseas
 * @property string $created_by_id
 * @property string $created_by_name
 * @property string $created_datetime
 * @property string $aliasModel
 */
abstract class AssetTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.ASSET_TBL';
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
            [['asset_id'], 'required'],
            [['fixed_asst_account', 'note', 'scrap_proposal_file', 'bac_file', 'scraping_file', 'model_used'], 'string'],
            [['purchase_date', 'LAST_UPDATE', 'DateDisc', 'expired_date', 'created_datetime'], 'safe'],
            [['report_type'], 'integer'],
            [['price', 'price_usd', 'qty', 'AtCost', 'NBV'], 'number'],
            [['asset_id', 'qr', 'ip_address', 'jenis', 'manufacture', 'ram_desc', 'rom_desc', 'asset_category', 'network', 'display', 'camera', 'battery', 'loc_type', 'LOC', 'area', 'project', 'manager_name', 'department_pic', 'cost_centre', 'department_name', 'section_name', 'nik', 'NAMA_KARYAWAN', 'primary_picture', 'scrap_slip_no', 'scrap_by_id', 'scrap_pic_id', 'status', 'label', 'img_filename', 'part', 'domestic_overseas', 'created_by_id'], 'string', 'max' => 50],
            [['computer_name'], 'string', 'max' => 400],
            [['manufacture_desc', 'cpu_desc', 'os_desc', 'location'], 'string', 'max' => 100],
            [['cur'], 'string', 'max' => 3],
            [['FINANCE_ASSET', 'Discontinue', 'propose_scrap'], 'string', 'max' => 1],
            [['scrap_by_name', 'scrap_pic_name', 'created_by_name'], 'string', 'max' => 250],
            [['asset_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'asset_id' => 'Asset ID',
            'qr' => 'Qr',
            'ip_address' => 'Ip Address',
            'computer_name' => 'Computer Name',
            'jenis' => 'Jenis',
            'manufacture' => 'Manufacture',
            'manufacture_desc' => 'Manufacture Desc',
            'cpu_desc' => 'Cpu Desc',
            'ram_desc' => 'Ram Desc',
            'rom_desc' => 'Rom Desc',
            'os_desc' => 'Os Desc',
            'fixed_asst_account' => 'Fixed Asst Account',
            'asset_category' => 'Asset Category',
            'purchase_date' => 'Purchase Date',
            'report_type' => 'Report Type',
            'LAST_UPDATE' => 'Last Update',
            'network' => 'Network',
            'display' => 'Display',
            'camera' => 'Camera',
            'battery' => 'Battery',
            'note' => 'Note',
            'loc_type' => 'Loc Type',
            'LOC' => 'Loc',
            'location' => 'Location',
            'area' => 'Area',
            'project' => 'Project',
            'cur' => 'Cur',
            'price' => 'Price',
            'price_usd' => 'Price Usd',
            'manager_name' => 'Manager Name',
            'department_pic' => 'Department Pic',
            'cost_centre' => 'Cost Centre',
            'department_name' => 'Department Name',
            'section_name' => 'Section Name',
            'nik' => 'Nik',
            'NAMA_KARYAWAN' => 'Nama Karyawan',
            'primary_picture' => 'Primary Picture',
            'FINANCE_ASSET' => 'Finance Asset',
            'qty' => 'Qty',
            'AtCost' => 'At Cost',
            'Discontinue' => 'Discontinue',
            'DateDisc' => 'Date Disc',
            'scrap_slip_no' => 'Scrap Slip No',
            'scrap_by_id' => 'Scrap By ID',
            'scrap_by_name' => 'Scrap By Name',
            'scrap_pic_id' => 'Scrap Pic ID',
            'scrap_pic_name' => 'Scrap Pic Name',
            'scrap_proposal_file' => 'Scrap Proposal File',
            'bac_file' => 'Bac File',
            'scraping_file' => 'Scraping File',
            'status' => 'Status',
            'label' => 'Label',
            'NBV' => 'Nbv',
            'propose_scrap' => 'Propose Scrap',
            'expired_date' => 'Expired Date',
            'img_filename' => 'Img Filename',
            'model_used' => 'Model Used',
            'part' => 'Part',
            'domestic_overseas' => 'Domestic Overseas',
            'created_by_id' => 'Created By ID',
            'created_by_name' => 'Created By Name',
            'created_datetime' => 'Created Datetime',
        ];
    }




}
