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
    'page_title' => 'Office Kanban Workflow (Supplier Payment)',
    'tab_title' => 'Office Kanban Workflow',
    'breadcrumbs_title' => 'Office Kanban Workflow'
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
    .container {width: auto;}
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
        border:1px solid darkgray;
        background-color: gray;
        color: white;
        font-size: 24px;
        border-bottom: 7px solid darkgray;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid darkgray;
        font-size: 3.5em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        height: 130px;
    }
    .table > tfoot > tr > td{
        border:1px solid darkgray;
        font-size: 3.5em;
        background-color: rgba(255, 255, 255, 0.1);
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 130px;
    }
    .icon-status {font-size : 2em;}

");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    window.setInterval(function(){
        $('.blinked').toggle();
    },600);
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


<table class="table table-responsive">
    <thead>
        <tr>
            <th rowspan="3" style="background: transparent; border-left: 0px;"></th>
            <th class="text-center">WAREHOUSE</th>
            <th class="text-center" colspan="4">PURCHASING</th>
            <th class="text-center" colspan="4">ACCOUNTING</th>
        </tr>
        <tr>
            <th class="text-center">Kanban</th>
            <th class="text-center" colspan="2">Document Received</th>
            <th class="text-center" colspan="2">Document Verification</th>
            <th class="text-center" colspan="2">Accounting Verification</th>
            <th class="text-center" colspan="2">Accounting Paid</th>
        </tr>
        <tr>
            <th class="text-center">Document</th>
            <th class="text-center">TARGET</th>
            <th class="text-center">BALANCE</th>
            <th class="text-center">TARGET</th>
            <th class="text-center">BALANCE</th>
            <th class="text-center">TARGET</th>
            <th class="text-center">BALANCE</th>
            <th class="text-center">TARGET</th>
            <th class="text-center">BALANCE</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>DIRECT</td>
            <td class="text-center"><?= number_format($data['direct']['kanban_doc']); ?></td>
            <td class="text-center"><?= number_format($data['direct']['pch']['received']['target']); ?></td>
            <td class="text-center"><?= $data['direct']['pch']['received']['balance'] == 0 ? '0' : Html::a(number_format($data['direct']['pch']['received']['balance']), ['period' => $model->period, 'pch-kanban-detail',
                'direct_indirect' => '01-SAP',
                'balance_no' => 1
            ], ['style' => 'color: red; font-weight: bold;', 'target' => '_blank']); ?></td>
            <td class="text-center"><?= number_format($data['direct']['pch']['verification']['target']); ?></td>
            <td class="text-center"><?= $data['direct']['pch']['verification']['balance'] == 0 ? '0' : Html::a(number_format($data['direct']['pch']['verification']['balance']), ['period' => $model->period, 'pch-kanban-detail',
                'direct_indirect' => '01-SAP',
                'balance_no' => 2
            ], ['style' => 'color: red; font-weight: bold;', 'target' => '_blank']); ?></td>
            <td class="text-center"><?= number_format($data['direct']['acc']['verification']['target']); ?></td>
            <td class="text-center"><?= $data['direct']['acc']['verification']['balance'] == 0 ? '0' : Html::a(number_format($data['direct']['acc']['verification']['balance']), ['period' => $model->period, 'pch-kanban-detail',
                'direct_indirect' => '01-SAP',
                'balance_no' => 3
            ], ['style' => 'color: red; font-weight: bold;', 'target' => '_blank']); ?></td>
            <td class="text-center"><?= number_format($data['direct']['acc']['paid']['target']); ?></td>
            <td class="text-center"><?= $data['direct']['acc']['paid']['balance'] == 0 ? '0' : Html::a(number_format($data['direct']['acc']['paid']['balance']), ['period' => $model->period, 'pch-kanban-detail',
                'direct_indirect' => '01-SAP',
                'balance_no' => 4
            ], ['style' => 'color: red; font-weight: bold;', 'target' => '_blank']); ?></td>
        </tr>
        <tr>
            <td>INDIRECT</td>
            <td class="text-center"><?= number_format($data['indirect']['kanban_doc']); ?></td>
            <td class="text-center"><?= number_format($data['indirect']['pch']['received']['target']); ?></td>
            <td class="text-center"><?= $data['indirect']['pch']['received']['balance'] == 0 ? '0' : Html::a(number_format($data['indirect']['pch']['received']['balance']), ['period' => $model->period, 'pch-kanban-detail',
                'direct_indirect' => '02-NICE',
                'balance_no' => 1
            ], ['style' => 'color: red; font-weight: bold;', 'target' => '_blank']); ?></td>
            <td class="text-center"><?= number_format($data['indirect']['pch']['verification']['target']); ?></td>
            <td class="text-center"><?= $data['indirect']['pch']['verification']['balance'] == 0 ? '0' : Html::a(number_format($data['indirect']['pch']['verification']['balance']), ['period' => $model->period, 'pch-kanban-detail',
                'direct_indirect' => '02-NICE',
                'balance_no' => 2
            ], ['style' => 'color: red; font-weight: bold;', 'target' => '_blank']); ?></td>
            <td class="text-center"><?= number_format($data['indirect']['acc']['verification']['target']); ?></td>
            <td class="text-center"><?= $data['indirect']['acc']['verification']['balance'] == 0 ? '0' : Html::a(number_format($data['indirect']['acc']['verification']['balance']), ['period' => $model->period, 'pch-kanban-detail',
                'direct_indirect' => '02-NICE',
                'balance_no' => 3
            ], ['style' => 'color: red; font-weight: bold;', 'target' => '_blank']); ?></td>
            <td class="text-center"><?= number_format($data['indirect']['acc']['paid']['target']); ?></td>
            <td class="text-center"><?= $data['indirect']['acc']['paid']['balance'] == 0 ? '0' : Html::a(number_format($data['indirect']['acc']['paid']['balance']), ['period' => $model->period, 'pch-kanban-detail',
                'direct_indirect' => '02-NICE',
                'balance_no' => 4
            ], ['style' => 'color: red; font-weight: bold;', 'target' => '_blank']); ?></td>
        </tr>
    </tbody>
    <tfoot>
        <td class="text-center">Total</td>
            
    </tfoot>
</table>