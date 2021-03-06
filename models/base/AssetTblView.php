<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.ASSET_TBL_VIEW".
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
 * @property string $status
 * @property string $label
 * @property double $NBV
 * @property string $propose_scrap
 * @property string $expired_date
 * @property string $img_filename
 * @property string $LOC_CATEGORY
 * @property string $LOC_GROUP
 * @property string $LOC_GROUP_DESC
 * @property string $LOC_AREA
 * @property string $CC_GROUP
 * @property string $CC_DESC
 * @property string $aliasModel
 */
abstract class AssetTblView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.ASSET_TBL_VIEW';
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
            [['asset_id', 'qr', 'ip_address', 'computer_name', 'jenis', 'manufacture', 'manufacture_desc', 'cpu_desc', 'ram_desc', 'rom_desc', 'os_desc', 'fixed_asst_account', 'asset_category', 'network', 'display', 'camera', 'battery', 'note', 'loc_type', 'LOC', 'location', 'area', 'project', 'cur', 'manager_name', 'department_pic', 'cost_centre', 'department_name', 'section_name', 'nik', 'NAMA_KARYAWAN', 'primary_picture', 'FINANCE_ASSET', 'Discontinue', 'status', 'label', 'propose_scrap', 'img_filename', 'LOC_CATEGORY', 'LOC_GROUP', 'LOC_GROUP_DESC', 'LOC_AREA', 'CC_GROUP', 'CC_DESC'], 'string'],
            [['purchase_date', 'LAST_UPDATE', 'DateDisc', 'expired_date'], 'safe'],
            [['report_type'], 'integer'],
            [['price', 'price_usd', 'qty', 'AtCost', 'NBV'], 'number']
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
            'LAST_UPDATE' => 'Last  Update',
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
            'NAMA_KARYAWAN' => 'Nama  Karyawan',
            'primary_picture' => 'Primary Picture',
            'FINANCE_ASSET' => 'Finance  Asset',
            'qty' => 'Qty',
            'AtCost' => 'At Cost',
            'Discontinue' => 'Discontinue',
            'DateDisc' => 'Date Disc',
            'status' => 'Status',
            'label' => 'Label',
            'NBV' => 'Nbv',
            'propose_scrap' => 'Propose Scrap',
            'expired_date' => 'Expired Date',
            'img_filename' => 'Img Filename',
            'LOC_CATEGORY' => 'Loc  Category',
            'LOC_GROUP' => 'Loc  Group',
            'LOC_GROUP_DESC' => 'Loc  Group  Desc',
            'LOC_AREA' => 'Loc  Area',
            'CC_GROUP' => 'Cc  Group',
            'CC_DESC' => 'Cc  Desc',
        ];
    }




}
