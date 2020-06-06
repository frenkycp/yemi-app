<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.FOTOCOPY_USER".
 *
 * @property string $USER_ID
 * @property string $USER_NAME
 * @property string $NIK
 * @property string $NIK_DESC
 * @property string $COST_CENTER
 * @property string $COST_CENTER_DESC
 * @property string $EMAIL_ADDRESS
 * @property string $aliasModel
 */
abstract class FotocopyUserTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.FOTOCOPY_USER';
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
            [['USER_ID'], 'required'],
            [['USER_ID', 'USER_NAME', 'NIK_DESC', 'COST_CENTER_DESC'], 'string', 'max' => 50],
            [['NIK'], 'string', 'max' => 10],
            [['COST_CENTER'], 'string', 'max' => 5],
            [['EMAIL_ADDRESS'], 'string', 'max' => 100],
            [['USER_ID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'USER_ID' => 'User ID',
            'USER_NAME' => 'User Name',
            'NIK' => 'Nik',
            'NIK_DESC' => 'Nik Desc',
            'COST_CENTER' => 'Cost Center',
            'COST_CENTER_DESC' => 'Cost Center Desc',
            'EMAIL_ADDRESS' => 'Email Address',
        ];
    }




}
