<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Purchasing Kanban Data',
    'tab_title' => 'Purchasing Kanban Data',
    'breadcrumbs_title' => 'Purchasing Kanban Data'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    //.container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #4A1573;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #4A1573;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #4A1573;
        font-size: 3.5em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 120px;
    }
    .table > tfoot > tr > td{
        border:1px solid #4A1573;
        font-size: 3.5em;
        background-color: #9163B5;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 120px;
    }

");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['pch-kanban-data']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->textInput(['maxlength' => 6]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>


<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th class="text-center" rowspan="2">Source</th>
            <th class="text-center">Request/Todo</th>
            <th class="text-center" colspan="3">In-Progress</th>
            <th class="text-center" rowspan="2">Done</th>
            <th class="text-center" rowspan="2">Transfer</th>
        </tr>
        <tr>
            <th class="text-center">(Invoice Wating)</th>
            <th class="text-center">Normal</th>
            <th class="text-center">Harga</th>
            <th class="text-center">Late</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">SAP</td>
            <td class="text-center"><?= number_format($data['sap']['request_qty']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['in_progress_normal']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['in_progress_harga']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['in_progress_late']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['done_qty']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['trf_qty']); ?></td>
        </tr>
        <tr>
            <td class="text-center">NICE</td>
            <td class="text-center"><?= number_format($data['nice']['request_qty']); ?></td>
            <td class="text-center"><?= number_format($data['nice']['in_progress_normal']); ?></td>
            <td class="text-center"><?= number_format($data['nice']['in_progress_harga']); ?></td>
            <td class="text-center"><?= number_format($data['nice']['in_progress_late']); ?></td>
            <td class="text-center"><?= number_format($data['nice']['done_qty']); ?></td>
            <td class="text-center"><?= number_format($data['nice']['trf_qty']); ?></td>
        </tr>
    </tbody>
    <tfoot>
        <td class="text-center">Total</td>
            <td class="text-center"><?= number_format($data['sap']['request_qty'] + $data['nice']['request_qty']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['in_progress_normal'] + $data['nice']['in_progress_normal']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['in_progress_harga'] + $data['nice']['in_progress_harga']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['in_progress_late'] + $data['nice']['in_progress_late']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['done_qty'] + $data['nice']['done_qty']); ?></td>
            <td class="text-center"><?= number_format($data['sap']['trf_qty'] + $data['nice']['trf_qty']); ?></td>
    </tfoot>
</table>