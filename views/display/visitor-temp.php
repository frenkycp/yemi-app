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
    'page_title' => 'Visitor Temperature Data',
    'tab_title' => 'Visitor Temperature Data',
    'breadcrumbs_title' => 'Visitor Temperature Data'
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
    #myTable > tbody > tr:nth-child(odd) > td {background-color: #2f2f2f; color: white;}
    #myTable > tbody > tr:nth-child(even) > td {background-color: #121213; color: white;}
    #myTable > thead > tr > th {background-color: #61258e; color: #ffeb3b;}
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

$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#myTable').DataTable({
        'pageLength': 15,
        'order': [[ 0, 'desc' ]]
    });
});");

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['visitor-temp']),
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
<div class="panel panel-primary" style="background-color: black;">
    <div class="panel-heading">
        <h3 class="panel-title">Visitor Temperature Data</h3>
    </div>
    <div class="panel-body">
        <table id="myTable" class="table">
            <thead>
                <tr>
                    <th class="text-center">Time</th>
                    <th>Visitor Name</th>
                    <th>Visitor Company</th>
                    <th>Temperature (&deg;C)</th>
                    <th>PIC</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visitor_data as $key => $value): ?>
                    <tr style="font-size: 0.84em;">
                        <td class="text-center"><?= $value->tgl; ?></td>
                        <td><?= $value->visitor_name; ?></td>
                        <td><?= $value->visitor_comp; ?></td>
                        <td><?= $value->suhu; ?></td>
                        <td><?= $value->emp_name . ' <small>(' . $value->emp_dept . ')</small>' ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>