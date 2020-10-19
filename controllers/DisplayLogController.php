<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\ShipReservationDtr;

/**
 * 
 */
class DisplayLogController extends Controller
{
	public function actionShipReservationSummary($value='')
	{
		//$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        $tmp_reservation_summary = ShipReservationDtr::find()
        ->select([
        	'main_40hc' => 'SUM(CASE WHEN PATINDEX(\'%MAIN%\', FLAG_DESC) > 0 THEN CNT_40HC ELSE 0 END)',
        	'sub_40hc' => 'SUM(CASE WHEN PATINDEX(\'%SUB%\', FLAG_DESC) > 0 THEN CNT_40HC ELSE 0 END)',
        	'backup_40hc' => 'SUM(CASE WHEN PATINDEX(\'%BACK-UP%\', FLAG_DESC) > 0 THEN CNT_40HC ELSE 0 END)',
        	'main_40' => 'SUM(CASE WHEN PATINDEX(\'%MAIN%\', FLAG_DESC) > 0 THEN CNT_40 ELSE 0 END)',
        	'sub_40' => 'SUM(CASE WHEN PATINDEX(\'%SUB%\', FLAG_DESC) > 0 THEN CNT_40 ELSE 0 END)',
        	'backup_40' => 'SUM(CASE WHEN PATINDEX(\'%BACK-UP%\', FLAG_DESC) > 0 THEN CNT_40 ELSE 0 END)',
        	'main_20' => 'SUM(CASE WHEN PATINDEX(\'%MAIN%\', FLAG_DESC) > 0 THEN CNT_20 ELSE 0 END)',
        	'sub_20' => 'SUM(CASE WHEN PATINDEX(\'%SUB%\', FLAG_DESC) > 0 THEN CNT_20 ELSE 0 END)',
        	'backup_20' => 'SUM(CASE WHEN PATINDEX(\'%BACK-UP%\', FLAG_DESC) > 0 THEN CNT_20 ELSE 0 END)',
        ])
        ->where([
            'AND',
            ['>=', 'ETD', $model->from_date],
            ['<=', 'ETD', $model->to_date]
        ])
        ->one();

        return $this->render('ship-reservation-summary', [
            'model' => $model,
            'tmp_reservation_summary' => $tmp_reservation_summary,
        ]);
	}
}