<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.TRACE_ITEM_REQUEST_PC".
 *
 * @property string $REQUEST_ID
 * @property string $LOT_NO
 * @property integer $CATEGORY
 * @property string $CREATE_BY_ID
 * @property string $CREATE_BY_NAME
 * @property string $CREATE_DATETIME
 * @property string $PO_NO
 * @property string $aliasModel
 */
abstract class TraceItemRequestPc extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.TRACE_ITEM_REQUEST_PC';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_wsus');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['REQUEST_ID'], 'required'],
            [['CATEGORY'], 'integer'],
            [['CREATE_DATETIME'], 'safe'],
            [['REQUEST_ID', 'LOT_NO', 'CREATE_BY_ID', 'PO_NO'], 'string', 'max' => 50],
            [['CREATE_BY_NAME'], 'string', 'max' => 150],
            [['REQUEST_ID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'REQUEST_ID' => 'Request ID',
            'LOT_NO' => 'Lot No',
            'CATEGORY' => 'Category',
            'CREATE_BY_ID' => 'Create By ID',
            'CREATE_BY_NAME' => 'Create By Name',
            'CREATE_DATETIME' => 'Create Datetime',
            'PO_NO' => 'Po No',
        ];
    }




}
