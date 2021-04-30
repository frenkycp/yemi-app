<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\CovidPatrolLoc;

class AjaxRepositoryController extends Controller
{
    public function actionCovidPatrolLoc($LOC_ID)
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $tmp_data = CovidPatrolLoc::findOne($LOC_ID);

        $data = [
            'loc_name' => $tmp_data->LOC_NAME,
            'pic_id' => $tmp_data->PIC_ID,
            'pic_name' => $tmp_data->PIC_NAME,
        ];
        return $data;
    }
}