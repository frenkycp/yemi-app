<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "inspection_report_view_percentage".
 *
 * @property string $periode
 * @property integer $week_no
 * @property string $proddate
 * @property string $total_data
 * @property string $total_no_check
 * @property string $total_ok
 * @property string $total_ng
 * @property string $open_percentage
 * @property string $ok_percentage
 * @property string $ng_percentage
 * @property string $aliasModel
 */
abstract class InspectionReportViewPercentage extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inspection_report_view_percentage';
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
            [['week_no', 'total_data'], 'integer'],
            [['proddate'], 'required'],
            [['total_no_check', 'total_ok', 'total_ng', 'open_percentage', 'ok_percentage', 'ng_percentage'], 'number'],
            [['periode'], 'string', 'max' => 6],
            [['proddate'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'periode' => 'Periode',
            'week_no' => 'Week No',
            'proddate' => 'Proddate',
            'total_data' => 'Total Data',
            'total_no_check' => 'Total No Check',
            'total_ok' => 'Total Ok',
            'total_ng' => 'Total Ng',
            'open_percentage' => 'Open Percentage',
            'ok_percentage' => 'Ok Percentage',
            'ng_percentage' => 'Ng Percentage',
        ];
    }




}
