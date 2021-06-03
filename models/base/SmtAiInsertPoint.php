<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SMT_AI_INSERT_POINT".
 *
 * @property string $PART_NO
 * @property string $PARENT_PART_NO
 * @property integer $POINT_SMT
 * @property integer $POINT_RG
 * @property integer $POINT_AV
 * @property integer $POINT_JV
 * @property integer $POINT_TOTAL
 * @property string $LAST_UPDATE
 * @property integer $FLAG
 * @property string $aliasModel
 */
abstract class SmtAiInsertPoint extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SMT_AI_INSERT_POINT';
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
            [['PART_NO'], 'required'],
            [['POINT_SMT', 'POINT_RG', 'POINT_AV', 'POINT_JV', 'POINT_TOTAL', 'FLAG'], 'integer'],
            [['LAST_UPDATE'], 'safe'],
            [['PART_NO', 'PARENT_PART_NO'], 'string', 'max' => 50],
            [['PART_NO'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PART_NO' => 'Part No',
            'PARENT_PART_NO' => 'Parent Part No',
            'POINT_SMT' => 'Point Smt',
            'POINT_RG' => 'Point Rg',
            'POINT_AV' => 'Point Av',
            'POINT_JV' => 'Point Jv',
            'POINT_TOTAL' => 'Point Total',
            'LAST_UPDATE' => 'Last Update',
            'FLAG' => 'Flag',
        ];
    }




}
