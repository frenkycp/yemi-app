<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.HRGA_DOC_TBL".
 *
 * @property string $DOC_ID
 * @property string $DOC_NAME
 * @property integer $REV
 * @property string $LAST_UPDATE
 * @property string $ATTACHMENT
 * @property integer $FLAG
 * @property string $aliasModel
 */
abstract class HrgaDocTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.HRGA_DOC_TBL';
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
            [['DOC_ID'], 'required'],
            [['REV', 'FLAG'], 'integer'],
            [['LAST_UPDATE'], 'safe'],
            [['ATTACHMENT'], 'string'],
            [['DOC_ID'], 'string', 'max' => 50],
            [['DOC_NAME'], 'string', 'max' => 250],
            [['DOC_ID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DOC_ID' => 'Doc ID',
            'DOC_NAME' => 'Doc Name',
            'REV' => 'Rev',
            'LAST_UPDATE' => 'Last Update',
            'ATTACHMENT' => 'Attachment',
            'FLAG' => 'Flag',
        ];
    }




}
