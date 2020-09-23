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
    'page_title' => 'Car Park Usage',
    'tab_title' => 'Car Park Usage',
    'breadcrumbs_title' => 'Car Park Usage'
];

//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCssFile('@web/css/component.css');
$this->registerJsFile('@web/js/snap.svg-min.js');
$this->registerJsFile('@web/js/classie.js');
$this->registerJsFile('@web/js/svgLoader.js');

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; text-align: center;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    .content-header>h1 {font-size: 2.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .form-horizontal .control-label {padding-top: 0px;}
    .myTable {font-size: 1em; color: white; letter-spacing: 1px;}
    //.myTable > tbody > tr:nth-child(odd) > td {background-color: #2f2f2f; color: white;}
    //.myTable > tbody > tr:nth-child(even) > td {background-color: #121213; color: white;}
    .myTable > thead > tr > th {background-color: #61258e; color: #ffeb3b;}
    .myTable > tbody > tr > td {font-size: 0.8em;}
    .dataTables_wrapper {color: white;}
    .table-title {font-size: 1.5em;}
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
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['car-park-usage']),
]); ?>
<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->dropDownList(ArrayHelper::map(app\models\CarParkAttendance::find()
        ->select('period')
        ->groupBy('period')
        ->orderBy('period DESC')
        ->all(), 'period', 'period')); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'account_type')->dropDownList([
            'COORDINATOR' => 'COORDINATOR',
            'MANAGER' => 'MANAGER',
        ]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<br/>

<div class="panel panel-default">
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/dark-unica',
                //'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 450,
                    'style' => [
                        'fontFamily' => 'sans-serif'
                    ],
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => null
                ],
                'subtitle' => [
                    'text' => null
                ],
                'xAxis' => [
                    'type' => 'datetime',
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Percentage'
                    ],
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            //'color' => 'white',
                            //'fontWeight' => 'bold',
                            'fontSize' => '20px',
                        ],
                    ],
                ],
                'legend' => [
                    'enabled' => true,
                    'itemStyle' => [
                        'fontSize' => '16px',
                    ],
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => false,
                            
                        ]
                    ],
                ],
                'series' => $data
            ],
        ]);
        ?>
    </div>
</div>