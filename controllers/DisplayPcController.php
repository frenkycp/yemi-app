<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\SapGrGiByLocLog;

class DisplayPcController extends Controller
{
    public function actionScrapSummary()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');

        $model->period = date('Ym');

        if ($model->load($_GET)) {

        }

        $tmp_data = SapGrGiByLocLog::find()
        ->select([
            'storage_loc', 'storage_loc_desc',
            'in_qty' => 'SUM(receipt_qty)',
            'in_amt' => 'SUM(receipt_amt)',
            'out_qty' => 'SUM(issue_qty)',
            'out_amt' => 'SUM(issue_qty_amt)',
            'balance_qty' => 'SUM(ending_qty)',
            'balance_amt' => 'SUM(ending_amt)',
        ])
        ->where([
            'period' => $model->period,
            'scrap_centre' => 'Y'
        ])->groupBy(['storage_loc', 'storage_loc_desc'])->orderBy('storage_loc')->all();

        return $this->render('scrap-summary', [
            'data' => $tmp_data,
            'model' => $model,
        ]);
    }
}