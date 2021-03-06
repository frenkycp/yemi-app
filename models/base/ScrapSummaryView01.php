<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SCRAP_SUMMARY_VIEW_01".
 *
 * @property string $id
 * @property string $period
 * @property string $category
 * @property string $category_desc
 * @property string $val_cls
 * @property string $val_cls_desc
 * @property string $plant
 * @property string $plant_desc
 * @property string $process
 * @property string $process_desc
 * @property string $storage_loc
 * @property string $storage_loc_desc
 * @property string $storage_loc_new
 * @property string $storage_loc_desc_new
 * @property string $currency
 * @property string $material
 * @property string $descriptions
 * @property string $price_type
 * @property double $price
 * @property string $uom
 * @property double $begin_qty
 * @property double $begin_amt
 * @property double $receipt_qty
 * @property double $receipt_amt
 * @property double $issue_qty
 * @property double $issue_qty_amt
 * @property double $issue_other_qty
 * @property double $issue_other_amt
 * @property double $std_price_var
 * @property double $ending_qty
 * @property double $ending_amt
 * @property string $flg
 * @property string $analyst
 * @property string $analyst_desc
 * @property string $delivery_pic
 * @property string $division
 * @property string $model
 * @property string $product_type
 * @property string $scrap_centre
 * @property string $dom_imp
 * @property string $dg
 * @property string $fiscal
 * @property string $aliasModel
 */
abstract class ScrapSummaryView01 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SCRAP_SUMMARY_VIEW_01';
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
            [['id'], 'required'],
            [['price', 'begin_qty', 'begin_amt', 'receipt_qty', 'receipt_amt', 'issue_qty', 'issue_qty_amt', 'issue_other_qty', 'issue_other_amt', 'std_price_var', 'ending_qty', 'ending_amt'], 'number'],
            [['model'], 'string'],
            [['id', 'analyst_desc', 'delivery_pic', 'division', 'product_type', 'scrap_centre', 'dg'], 'string', 'max' => 50],
            [['period', 'fiscal'], 'string', 'max' => 7],
            [['category', 'currency', 'uom'], 'string', 'max' => 3],
            [['category_desc', 'val_cls_desc', 'plant_desc', 'process_desc', 'storage_loc_desc', 'storage_loc_desc_new', 'price_type'], 'string', 'max' => 30],
            [['val_cls', 'plant'], 'string', 'max' => 4],
            [['process', 'storage_loc', 'storage_loc_new'], 'string', 'max' => 5],
            [['material'], 'string', 'max' => 11],
            [['descriptions'], 'string', 'max' => 40],
            [['flg'], 'string', 'max' => 10],
            [['analyst'], 'string', 'max' => 6],
            [['dom_imp'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'period' => 'Period',
            'category' => 'Category',
            'category_desc' => 'Category Desc',
            'val_cls' => 'Val Cls',
            'val_cls_desc' => 'Val Cls Desc',
            'plant' => 'Plant',
            'plant_desc' => 'Plant Desc',
            'process' => 'Process',
            'process_desc' => 'Process Desc',
            'storage_loc' => 'Storage Loc',
            'storage_loc_desc' => 'Storage Loc Desc',
            'storage_loc_new' => 'Storage Loc New',
            'storage_loc_desc_new' => 'Storage Loc Desc New',
            'currency' => 'Currency',
            'material' => 'Material',
            'descriptions' => 'Descriptions',
            'price_type' => 'Price Type',
            'price' => 'Price',
            'uom' => 'Uom',
            'begin_qty' => 'Begin Qty',
            'begin_amt' => 'Begin Amt',
            'receipt_qty' => 'Receipt Qty',
            'receipt_amt' => 'Receipt Amt',
            'issue_qty' => 'Issue Qty',
            'issue_qty_amt' => 'Issue Qty Amt',
            'issue_other_qty' => 'Issue Other Qty',
            'issue_other_amt' => 'Issue Other Amt',
            'std_price_var' => 'Std Price Var',
            'ending_qty' => 'Ending Qty',
            'ending_amt' => 'Ending Amt',
            'flg' => 'Flg',
            'analyst' => 'Analyst',
            'analyst_desc' => 'Analyst Desc',
            'delivery_pic' => 'Delivery Pic',
            'division' => 'Division',
            'model' => 'Model',
            'product_type' => 'Product Type',
            'scrap_centre' => 'Scrap Centre',
            'dom_imp' => 'Dom Imp',
            'dg' => 'Dg',
            'fiscal' => 'Fiscal',
        ];
    }




}
