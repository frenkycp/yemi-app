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
    'page_title' => 'Daily Production Schedule',
    'tab_title' => 'Daily Production Schedule',
    'breadcrumbs_title' => 'Daily Production Schedule'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; display: none;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .form-horizontal .control-label {padding-top: 0px;}
    #myTable {font-size: 1.3em; letter-spacing: 1px; color: white;}
    //#myTable > tbody > tr:nth-child(odd) > td {background-color: #2f2f2f; color: white;}
    //#myTable > tbody > tr:nth-child(even) > td {background-color: #121213; color: white;}
    #myTable > thead > tr > th {background-color: #61258e; color: #ffeb3b;}
    #myTable > tbody > tr > td {font-size: 0.8em;}
    .dataTables_wrapper {color: white;}
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 1800000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#myTable').DataTable({
        'pageLength': 15,
        'order': [[ 0, 'desc' ]]
    });
});");*/

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
$total_plan = $total_act = $total_balance = 0;
?>
<h3 style="color: white;"><u>Production Output Daily Progress</u></h3 style="color: white;">
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['daily-prod-schedule']),
]); ?>

<div class="row">
    <div class="col-md-4">
        <?php echo '<label class="control-label">Select date range</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'from_date',
            'attribute2' => 'to_date',
            'options' => ['placeholder' => 'Start date'],
            'options2' => ['placeholder' => 'End date'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<br/>
<table id="myTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <?php foreach ($data as $key => $value): ?>
                <th class="text-center"><?= $key; ?></th>
            <?php endforeach ?>
            <th class="text-center">Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Plan</td>
            <?php foreach ($data as $key => $value): ?>
                <td class="text-center"><?= number_format($value['plan_qty']); ?></td>
                <?php
                $total_plan += $value['plan_qty'];
                ?>
            <?php endforeach ?>
            <td class="text-center"><?= number_format($total_plan); ?></td>
        </tr>
        <tr>
            <td>Output</td>
            <?php foreach ($data as $key => $value): ?>
                <td class="text-center"><?= number_format($value['act_qty']); ?></td>
                <?php
                $total_act += $value['act_qty'];
                ?>
            <?php endforeach ?>
            <td class="text-center"><?= number_format($total_act); ?></td>
        </tr>
        <tr>
            <td class="bg-gray-active color-palette">Balance</td>
            <?php foreach ($data as $key => $value): ?>
                <td class="text-center bg-gray-active color-palette<?= $value['balance_qty'] < 0 ? ' text-red' : ''; ?>"><?= number_format($value['balance_qty']); ?></td>
            <?php endforeach ?>
            <?php
            $total_balance = $total_act - $total_plan;
            ?>
            <td class="text-center bg-gray-active color-palette<?= $total_balance < 0 ? ' text-red' : ''; ?>"><?= number_format($total_balance); ?></td>
        </tr>
    </tbody>
</table>