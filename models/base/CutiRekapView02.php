<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.CUTI_REKAP_VIEW_02".
 *
 * @property string $CUTI_ID
 * @property string $TYPE
 * @property string $NIK
 * @property string $CATEGORY
 * @property integer $TAHUN
 * @property integer $JUMLAH_CUTI
 * @property string $aliasModel
 */
abstract class CutiRekapView02 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.CUTI_REKAP_VIEW_02';
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
            [['CUTI_ID', 'TYPE', 'NIK', 'CATEGORY'], 'string'],
            [['TYPE'], 'required'],
            [['TAHUN', 'JUMLAH_CUTI'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CUTI_ID' => 'Cuti  ID',
            'TYPE' => 'Type',
            'NIK' => 'Nik',
            'CATEGORY' => 'Category',
            'TAHUN' => 'Tahun',
            'JUMLAH_CUTI' => 'Jumlah  Cuti',
        ];
    }




}
