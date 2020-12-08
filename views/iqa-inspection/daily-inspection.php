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
    'page_title' => 'IQC Monitoring List <span class="japanesse light-green">材料受け入れ管理表</span>',
    'tab_title' => 'IQC Monitoring List',
    'breadcrumbs_title' => 'IQC Monitoring List'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');

$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$css_string = "
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 1em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5; font-family: 'Open Sans', sans-serif;}
    .form-group {margin-bottom: 0px;}
    //body, .content-wrapper {background-color: #000;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .badge {font-weight: normal;}

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 3em;
        background: #121213;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border: 1px solid #595F66;
        border-top: 0px;
        background-color: #518469;
        color: #ffeb3b;
        font-size: 1.7em;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: white !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: yellow;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #yesterday-tbl > tbody > tr > td{
        border:1px solid #777474;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 2px;
        //height: 100px;
    }
    #popup-tbl > tfoot > tr > td {
        font-weight: bold;
        background-color: rgba(0, 0, 150, 0.3);
    }
    .top-minus-text {
        font-size: 16px !important;
    }
    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    .summary-tbl > tbody > tr:nth-child(odd) > td {background: #2f2f2f;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

$this->registerJs("$(function() {
   $('#myTable').DataTable({
        'order': [[ 1, 'desc' ]],
        'pageLength': 25
    });
});");

/*echo '<pre>';
print_r($fix_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['daily-inspection']),
]); ?>

<div style="float: right;">
    <span>Lot Out Target Ratio : <b><?= $target_ng_rate; ?>%</b></span>
    <div class="box box-warning box-solid">
        <div class="box-body no-padding">
            <span class="" style="font-size: 6em; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">Lot Out Ratio : <span class=""><?= $ng_rate; ?>%</span></span>
        </div>
    </div>
</div>
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
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
</div>
<span><i>Last Update : <?= date('d M \'Y H:i'); ?></i></span>
<div class=""></div>

<?php ActiveForm::end(); ?>

<div class="box box-primary">
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                ],
                'title' => [
                    'text' => null
                ],
                'subtitle' => [
                    'text' => ''
                ],
                'xAxis' => [
                    'type' => 'datetime',
                ],
                'yAxis' => [
                    'title' => [
                        'text' => null
                    ],
                    //'gridLineWidth' => 0,
                    //'max' => 1500
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    'xDateFormat' => '%A, %b %e %Y',
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                        ],
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                            ]
                        ]
                    ]
                ],
                'series' => $data
            ],
        ]);
        ?>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">NG Data Table</h3>
    </div>
    <div class="panel-body">
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="min-width: 80px;">Inc. Date</th>
                    <th>Last Update</th>
                    <th>Part No.</th>
                    <th>Part Name.</th>
                    <th>Qty In</th>
                    <th>Note</th>
                    <th>Remark</th>
                    <th>Vendor ID</th>
                    <th>Vendor Name</th>
                    <th>Tag Slip</th>
                    <th>Slip Reff.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ng_data_arr as $key => $value): ?>
                    <tr>
                        <td><?= date('Y-m-d', strtotime($value['POST_DATE'])); ?></td>
                        <td><?= date('Y-m-d H:i:s', strtotime($value['LAST_UPDATE'])); ?></td>
                        <td><?= $value['ITEM']; ?></td>
                        <td><?= $value['ITEM_DESC']; ?></td>
                        <td><?= number_format($value['QTY_IN']); ?></td>
                        <td><?= $value['NOTE']; ?></td>
                        <td><?= $value['Remark']; ?></td>
                        <td><?= $value['LOC']; ?></td>
                        <td><?= $value['LOC_DESC']; ?></td>
                        <td><?= $value['TAG_SLIP']; ?></td>
                        <td><?= $value['SLIP_REF']; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
    </div>
</div>

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>