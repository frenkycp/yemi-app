<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "inspection_judgement_data_view".
 *
 * @property string $pk
 * @property string $etd
 * @property string $ship
 * @property string $gmc
 * @property string $dst
 * @property integer $cntr
 * @property integer $total_plan
 * @property integer $total_output
 * @property string $total_ok
 * @property string $aliasModel
 */
abstract class InspectionJudgementDataView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inspection_judgement_data_view';
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
            [['pk', 'etd', 'ship', 'gmc', 'dst'], 'required'],
            [['etd', 'ship'], 'safe'],
            [['cntr', 'total_plan', 'total_output', 'total_ok'], 'integer'],
            [['pk'], 'string', 'max' => 35],
            [['gmc'], 'string', 'max' => 7],
            [['dst'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk' => 'Pk',
            'etd' => 'Etd',
            'ship' => 'Ship',
            'gmc' => 'Gmc',
            'dst' => 'Dst',
            'cntr' => 'Cntr',
            'total_plan' => 'Total Plan',
            'total_output' => 'Total Output',
            'total_ok' => 'Total Ok',
        ];
    }




}
