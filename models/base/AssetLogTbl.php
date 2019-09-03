<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.ASSET_LOG_TBL".
 *
 * @property integer $trans_id
 * @property string $trans_type
 * @property string $posting_date
 * @property string $asset_id
 * @property string $computer_name
 * @property string $from_loc
 * @property string $to_loc
 * @property string $user_id
 * @property string $user_desc
 * @property string $note
 * @property string $status
 * @property string $label
 * @property string $aliasModel
 */
abstract class AssetLogTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.ASSET_LOG_TBL';
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
            [['trans_type', 'asset_id', 'computer_name', 'from_loc', 'to_loc', 'user_id', 'user_desc', 'note', 'status', 'label'], 'string'],
            [['posting_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trans_id' => 'Trans ID',
            'trans_type' => 'Trans Type',
            'posting_date' => 'Posting Date',
            'asset_id' => 'Asset ID',
            'computer_name' => 'Computer Name',
            'from_loc' => 'From Loc',
            'to_loc' => 'To Loc',
            'user_id' => 'User ID',
            'user_desc' => 'User Desc',
            'note' => 'Note',
            'status' => 'Status',
            'label' => 'Label',
        ];
    }




}
