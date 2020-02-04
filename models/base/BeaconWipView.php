<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.BEACON_WIP_VIEW".
 *
 * @property string $id
 * @property string $uuid
 * @property string $major
 * @property string $minor
 * @property string $lot_number
 * @property string $start_date
 * @property string $lokasi
 * @property string $reader
 * @property double $distance
 * @property string $distance_last_update
 * @property string $review_date
 * @property string $mesin_id
 * @property string $mesin_description
 * @property string $kelompok
 * @property string $model_group
 * @property string $parent
 * @property string $parent_desc
 * @property string $gmc
 * @property string $gmc_desc
 * @property double $lot_qty
 * @property string $current_machine_start
 * @property string $jenis_mesin
 * @property string $lot_status
 * @property string $next_process
 * @property string $analyst
 * @property string $analyst_desc
 * @property string $aliasModel
 */
abstract class BeaconWipView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.BEACON_WIP_VIEW';
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
            [['id', 'uuid', 'major', 'minor', 'lot_number', 'lokasi', 'reader', 'mesin_id', 'mesin_description', 'kelompok', 'model_group', 'parent', 'parent_desc', 'gmc', 'gmc_desc', 'jenis_mesin', 'lot_status', 'next_process', 'analyst', 'analyst_desc'], 'string'],
            [['start_date', 'distance_last_update', 'review_date', 'current_machine_start'], 'safe'],
            [['distance', 'lot_qty'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'major' => 'Major',
            'minor' => 'Minor',
            'lot_number' => 'Lot Number',
            'start_date' => 'Start Date',
            'lokasi' => 'Lokasi',
            'reader' => 'Reader',
            'distance' => 'Distance',
            'distance_last_update' => 'Distance Last Update',
            'review_date' => 'Review Date',
            'mesin_id' => 'Mesin ID',
            'mesin_description' => 'Mesin Description',
            'kelompok' => 'Kelompok',
            'model_group' => 'Model Group',
            'parent' => 'Parent',
            'parent_desc' => 'Parent Desc',
            'gmc' => 'Gmc',
            'gmc_desc' => 'Gmc Desc',
            'lot_qty' => 'Lot Qty',
            'current_machine_start' => 'Current Machine Start',
            'jenis_mesin' => 'Jenis Mesin',
            'lot_status' => 'Lot Status',
            'next_process' => 'Next Process',
            'analyst' => 'Analyst',
            'analyst_desc' => 'Analyst Desc',
        ];
    }




}
