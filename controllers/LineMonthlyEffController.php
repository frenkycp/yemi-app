<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\DprLineEfficiencyView02;
use app\models\DprGmcEffView;
use app\models\SernoLosstime;
use app\models\SernoInput;
use app\models\HakAksesPlus;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class LineMonthlyEffController extends Controller
{
	public function actionIndex($value='')
	{
		date_default_timezone_set('Asia/Jakarta');
        $model = new \yii\base\DynamicModel([
            'gmc', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','gmc'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d') . '-1 year'));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

        if ($model->load($_GET)) {
            # code...
        }

        $eff_data_arr = DprLineEfficiencyView02::find()
	    ->where([
            'AND',
            ['>=', 'proddate', $model->from_date],
            ['<=', 'proddate', $model->to_date]
        ])
	    ->asArray()
	    ->all();

        return $this->render('index', [
        	'model' => $model
        ]);
	}
}