<?php

namespace app\models;

use Yii;
use \app\models\base\AssetTbl as BaseAssetTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ASSET_TBL".
 */
class AssetTbl extends BaseAssetTbl
{
    public $asset_name, $upload_file_proposal, $upload_file_bac, $upload_file_scraping, $upload_file_asset;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['upload_file_proposal', 'upload_file_bac', 'upload_file_scraping'], 'file']
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
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
                'fixed_asst_account' => 'Fixed Asset Account',
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
            ]
        );
    }

    public function getAssetName($value='')
    {
        return $this->asset_id . ' - ' . $this->computer_name;
    }
}
