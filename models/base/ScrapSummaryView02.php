<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SCRAP_SUMMARY_VIEW_02".
 *
 * @property string $period
 * @property string $storage_loc_new
 * @property string $storage_loc_desc_new
 * @property string $material
 * @property string $descriptions
 * @property string $model
 * @property double $in_qty
 * @property double $in_amt
 * @property string $aliasModel
 */
abstract class ScrapSummaryView02 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SCRAP_SUMMARY_VIEW_02';
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
            [['model'], 'string'],
            [['in_qty', 'in_amt'], 'number'],
            [['period'], 'string', 'max' => 7],
            [['storage_loc_new'], 'string', 'max' => 5],
            [['storage_loc_desc_new'], 'string', 'max' => 30],
            [['material'], 'string', 'max' => 11],
            [['descriptions'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period' => 'Period',
            'storage_loc_new' => 'Storage Loc New',
            'storage_loc_desc_new' => 'Storage Loc Desc New',
            'material' => 'Material',
            'descriptions' => 'Descriptions',
            'model' => 'Model',
            'in_qty' => 'In Qty',
            'in_amt' => 'In Amt',
        ];
    }




}
