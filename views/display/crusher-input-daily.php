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
    'page_title' => 'Plastic Crusher Recycle Monitoring <span class="japanesse light-green">プラクラッシャーのリサイクル管理</span>',
    'tab_title' => 'Plastic Crusher Recycle Monitoring',
    'breadcrumbs_title' => 'Plastic Crusher Recycle Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
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
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        font-size: 4em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        height: 100px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
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
    'action' => Url::to(['dross-input-daily']),
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
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="box box-primary box-solid">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/grid-light',
                    'themes/dark-unica',
                    //'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 300,
                        'zoomType' => 'x'
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => null,
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        'gridLineWidth' => 0
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Total Qty',
                        ],
                        'allowDecimals' => false,
                        'stackLabels' => [
                            'enabled' => true
                        ]
                        //'max' => 60,
                        //'tickInterval' => 10
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' =>true
                            ],
                        ],
                    ],
                    'series' => $data,
                ],
            ]);

            ?>
        </div>
    </div>
</div>
<div class="row text-center" style="font-size: 2.5em;">
    <div class="col-md-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">In (New)</h3>
            </div>
            <div class="panel-body">
                <?= number_format($total_in_new); ?> Kg (A)
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">In (Recycle)</h3>
            </div>
            <div class="panel-body"><?= number_format($total_in_recycle); ?> Kg (B)</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Out (Crusher)</h3>
            </div>
            <div class="panel-body">
                <?= number_format($total_dross); ?> Kg (C)
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Out (Scrap)</h3>
            </div>
            <div class="panel-body">
                <?= number_format($total_dross_scrap); ?> Kg (D)
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Stock Crusher</h3>
            </div>
            <div class="panel-body">
                <?= number_format($dross_stock['st_dross']); ?> Kg
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Stock Recylce</h3>
            </div>
            <div class="panel-body">
                <?= number_format($dross_stock['st_recycle']); ?> Kg
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <table class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="25%">Total IN<br/>[A + B]</th>
                    <th class="text-center" width="25%">IN (Recycle) Ratio<br/>[B / (A + B)]</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><?= number_format($total_in); ?> <span style="font-size: 0.3em;">Kg</span></td>
                    <td class="text-center"><?= number_format($in_recycle_ratio); ?> <span style="font-size: 0.3em;">%</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th class="text-center" width="25%">Total Scrap <span class="japanesse">処分量</span><br/>[D]</th>
                    <th class="text-center" width="25%">Scrap Ratio <span class="japanesse">処分率</span><br/>[D / A]</th>
                    <th class="text-center" width="25%">Recycle Ratio <span class="japanesse">再生率</span><br/>[B / A]</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><?= number_format($total_dross_scrap); ?> <span style="font-size: 0.3em;">Kg</span></td>
                    <td class="text-center"><?= number_format($scrap_ratio); ?> <span style="font-size: 0.3em;">%</span></td>
                    <td class="text-center"><?= number_format($recycle_ratio); ?> <span style="font-size: 0.3em;">%</span></td>
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>

