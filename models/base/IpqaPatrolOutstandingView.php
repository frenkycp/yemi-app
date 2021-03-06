<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.IPQA_PATROL_OUTSTANDING_VIEW".
 *
 * @property string $CC_ID
 * @property string $CC_GROUP
 * @property string $CC_DESC
 * @property integer $total_open
 * @property integer $total_pending
 * @property integer $total_rejected
 * @property integer $total_closed
 * @property integer $total_ok_due_date
 * @property string $aliasModel
 */
abstract class IpqaPatrolOutstandingView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.IPQA_PATROL_OUTSTANDING_VIEW';
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
            [['CC_ID', 'CC_GROUP', 'CC_DESC'], 'string'],
            [['total_open', 'total_pending', 'total_rejected', 'total_closed', 'total_ok_due_date'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CC_ID' => 'Cc  ID',
            'CC_GROUP' => 'Cc  Group',
            'CC_DESC' => 'Cc  Desc',
            'total_open' => 'Total Open',
            'total_pending' => 'Total Pending',
            'total_rejected' => 'Total Rejected',
            'total_closed' => 'Total Closed',
            'total_ok_due_date' => 'Total Ok Due Date',
        ];
    }




}
