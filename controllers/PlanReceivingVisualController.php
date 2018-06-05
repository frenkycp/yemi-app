<?php

namespace app\controllers;

use Yii;
use app\models\PlanReceiving;
use app\models\search\PlanReceivingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PlanReceivingPeriod;

class PlanReceivingVisualController extends Controller
{
	public function actionIndex()
	{
		$year_arr = [];
		$month_arr = [];
		$min_year = PlanReceiving::find()->select('MIN(CAST(LEFT(month_periode,4) as UNSIGNED)) as `min_year`')->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

		$model = new PlanReceivingPeriod();
		$model->month = date('m');
		$model->year = date('Y');
		if ($model->load($_POST))
		{

		}
		return $this->render('index',[
			'model' => $model,
			'year_arr' => $year_arr,
			'month_arr' => $month_arr
		]);
	}

	public function actionSearchData()
	{
		
	}
}