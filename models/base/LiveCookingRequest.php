<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.LIVE_COOKING_REQUEST".
 *
 * @property integer $SEQ
 * @property string $NIK_AND_DATE
 * @property string $NIK
 * @property string $NAMA_KARYAWAN
 * @property string $post_date
 * @property integer $qty_request
 * @property integer $qty_actual
 * @property integer $qty_diff
 * @property string $close_open
 * @property string $close_open_note
 * @property string $USER_CLOSE
 * @property string $USER_DESC_CLOSE
 * @property string $USER_LAST_UPDATE_CLOSE
 * @property string $id
 * @property string $cc
 * @property string $cc_desc
 * @property string $type
 * @property integer $week_no
 * @property string $start_date
 * @property string $end_date
 * @property string $USER_ID
 * @property string $USER_DESC
 * @property string $USER_LAST_UPDATE
 * @property string $aliasModel
 */
abstract class LiveCookingRequest extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.LIVE_COOKING_REQUEST';
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
            [['NIK_AND_DATE', 'NIK', 'NAMA_KARYAWAN'], 'required'],
            [['NIK_AND_DATE', 'NIK', 'NAMA_KARYAWAN', 'close_open', 'close_open_note', 'USER_CLOSE', 'USER_DESC_CLOSE', 'id', 'cc', 'cc_desc', 'type', 'USER_ID', 'USER_DESC'], 'string'],
            [['post_date', 'USER_LAST_UPDATE_CLOSE', 'start_date', 'end_date', 'USER_LAST_UPDATE'], 'safe'],
            [['qty_request', 'qty_actual', 'qty_diff', 'week_no'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SEQ' => 'Seq',
            'NIK_AND_DATE' => 'Nik  And  Date',
            'NIK' => 'Nik',
            'NAMA_KARYAWAN' => 'Nama  Karyawan',
            'post_date' => 'Post Date',
            'qty_request' => 'Qty Request',
            'qty_actual' => 'Qty Actual',
            'qty_diff' => 'Qty Diff',
            'close_open' => 'Close Open',
            'close_open_note' => 'Close Open Note',
            'USER_CLOSE' => 'User  Close',
            'USER_DESC_CLOSE' => 'User  Desc  Close',
            'USER_LAST_UPDATE_CLOSE' => 'User  Last  Update  Close',
            'id' => 'ID',
            'cc' => 'Cc',
            'cc_desc' => 'Cc Desc',
            'type' => 'Type',
            'week_no' => 'Week No',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'USER_ID' => 'User  ID',
            'USER_DESC' => 'User  Desc',
            'USER_LAST_UPDATE' => 'User  Last  Update',
        ];
    }




}
