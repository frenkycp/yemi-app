<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "klinik_obat_log_view".
 *
 * @property integer $id
 * @property string $klinik_input_pk
 * @property string $period
 * @property string $post_date
 * @property string $input_datetime
 * @property string $user_id
 * @property string $user_name
 * @property string $part_no
 * @property string $part_desc
 * @property double $qty
 * @property integer $flag
 * @property string $nik_sun_fish
 * @property string $nama
 * @property string $cost_center_name
 * @property integer $opsi
 * @property string $diagnosa
 * @property string $anamnesa
 * @property string $root_cause
 * @property double $sistolik
 * @property double $diastolik
 * @property double $temperature
 * @property string $aliasModel
 */
abstract class KlinikObatLogView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'klinik_obat_log_view';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mis7');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'flag', 'opsi'], 'integer'],
            [['post_date', 'input_datetime'], 'safe'],
            [['qty', 'sistolik', 'diastolik', 'temperature'], 'number'],
            [['klinik_input_pk'], 'string', 'max' => 50],
            [['period'], 'string', 'max' => 10],
            [['user_id', 'part_no', 'nik_sun_fish'], 'string', 'max' => 20],
            [['user_name', 'part_desc', 'nama', 'diagnosa', 'anamnesa', 'root_cause'], 'string', 'max' => 255],
            [['cost_center_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'klinik_input_pk' => 'Klinik Input Pk',
            'period' => 'Period',
            'post_date' => 'Post Date',
            'input_datetime' => 'Input Datetime',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'part_no' => 'Part No',
            'part_desc' => 'Part Desc',
            'qty' => 'Qty',
            'flag' => 'Flag',
            'nik_sun_fish' => 'Nik Sun Fish',
            'nama' => 'Nama',
            'cost_center_name' => 'Cost Center Name',
            'opsi' => 'Opsi',
            'diagnosa' => 'Diagnosa',
            'anamnesa' => 'Anamnesa',
            'root_cause' => 'Root Cause',
            'sistolik' => 'Sistolik',
            'diastolik' => 'Diastolik',
            'temperature' => 'Temperature',
        ];
    }




}
