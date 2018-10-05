<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tb_serno_losstime".
 *
 * @property string $pk
 * @property string $line
 * @property integer $mp
 * @property string $proddate
 * @property string $start_time
 * @property string $end_time
 * @property double $losstime
 * @property string $category
 * @property string $model
 * @property string $aliasModel
 */
abstract class SernoLosstime extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_serno_losstime';
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
            [['pk'], 'required'],
            [['mp'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['losstime'], 'number'],
            [['pk'], 'string', 'max' => 30],
            [['line'], 'string', 'max' => 15],
            [['proddate'], 'string', 'max' => 10],
            [['category', 'model'], 'string', 'max' => 255],
            [['pk'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk' => 'Pk',
            'line' => 'Line',
            'mp' => 'Mp',
            'proddate' => 'Proddate',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'losstime' => 'Losstime',
            'category' => 'Category',
            'model' => 'Model',
        ];
    }




}
