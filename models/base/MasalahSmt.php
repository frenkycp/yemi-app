<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base-model class for table "tbl_masalah_smt".
 *
 * @property string $kode_laporan_smt
 * @property string $kode_gmc
 * @property string $pcb_smt
 * @property string $side_smt
 * @property string $group_smt
 * @property string $pic_aoi
 * @property string $line_smt
 * @property string $pic_group
 * @property string $smt_cause
 * @property string $lokasi
 * @property integer $qty_smt
 * @property string $fotoawal
 * @property string $created_date
 * @property string $created_by
 * @property string $aliasModel
 */
abstract class MasalahSmt extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_masalah_smt';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_redy');
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_laporan_smt', 'kode_gmc', 'pcb_smt', 'side_smt', 'group_smt', 'pic_aoi', 'line_smt', 'pic_group', 'smt_cause', 'lokasi', 'qty_smt', 'fotoawal', 'created_date'], 'required'],
            [['qty_smt'], 'integer'],
            [['fotoawal'], 'string'],
            [['created_date'], 'safe'],
            [['kode_laporan_smt', 'pcb_smt', 'pic_aoi', 'line_smt', 'pic_group'], 'string', 'max' => 25],
            [['kode_gmc'], 'string', 'max' => 10],
            [['side_smt', 'group_smt'], 'string', 'max' => 2],
            [['smt_cause'], 'string', 'max' => 100],
            [['lokasi'], 'string', 'max' => 50],
            [['kode_laporan_smt'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_laporan_smt' => 'Kode Laporan Smt',
            'kode_gmc' => 'Kode Gmc',
            'pcb_smt' => 'Pcb Smt',
            'side_smt' => 'Side Smt',
            'group_smt' => 'Group Smt',
            'pic_aoi' => 'Pic Aoi',
            'line_smt' => 'Line Smt',
            'pic_group' => 'Pic Group',
            'smt_cause' => 'Smt Cause',
            'lokasi' => 'Lokasi',
            'qty_smt' => 'Qty Smt',
            'fotoawal' => 'Fotoawal',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
        ];
    }




}
