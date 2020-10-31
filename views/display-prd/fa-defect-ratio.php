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
    'page_title' => 'FA Defect Ratio <span class="japanesse light-green"></span>',
    'tab_title' => 'FA Defect Ratio',
    'breadcrumbs_title' => 'FA Defect Ratio'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
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
        font-size: 14px;
        background: white;
        color: black;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #777474 !important;
        background-color: rgb(255, 229, 153);
        color: black;
        font-size: 16px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: black !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: white;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    #summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
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
$total_kwh = 0;

/*echo '<pre>';
print_r($tmp_daily_ratio);
echo '</pre>';*/

$current_data = $data[$model->period];
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['fa-defect-ratio']),
]); ?>

<div class="row" style="padding-top: 10px;">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->textInput(); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<table class="table summary-tbl">
    <thead>
        <tr>
            <th>DEFECTS RATIO AT FA (<?= date('M\' Y', strtotime($model->period . '01')); ?>)</th>
            <th class="text-center">ALL MODELS</th>
            <th class="text-center">AV MODELS</th>
            <th class="text-center">PA MODELS</th>
            <th class="text-center">SN MODELS</th>
            <th class="text-center">B&O</th>
            <th class="text-center">DMI</th>
            <th class="text-center">PIANO</th>
            <th class="text-center">OTHER</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>DEFECT RATIO  % POST PROCESS</td>
            <td class="text-center"><?= $current_data['all']['post_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['av']['post_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['pa']['post_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['sn']['post_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['bo']['post_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['dmi']['post_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['piano']['post_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['other']['post_ratio']; ?>%</td>
        </tr>
        <tr>
            <td>DEFECT RATIO  % SELF PROCESS</td>
            <td class="text-center"><?= $current_data['all']['self_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['av']['self_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['pa']['self_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['sn']['self_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['bo']['self_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['dmi']['self_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['piano']['self_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['other']['self_ratio']; ?>%</td>
        </tr>
        <tr>
            <td>DEFECT RATIO  % PRE PROCESS</td>
            <td class="text-center"><?= $current_data['all']['pre_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['av']['pre_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['pa']['pre_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['sn']['pre_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['bo']['pre_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['dmi']['pre_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['piano']['pre_ratio']; ?>%</td>
            <td class="text-center"><?= $current_data['other']['pre_ratio']; ?>%</td>
        </tr>
        <tr>
            <td>OUTPUT QTY </td>
            <td class="text-center"><?= number_format($current_data['all']['output']); ?></td>
            <td class="text-center"><?= number_format($current_data['av']['output']); ?></td>
            <td class="text-center"><?= number_format($current_data['pa']['output']); ?></td>
            <td class="text-center"><?= number_format($current_data['sn']['output']); ?></td>
            <td class="text-center"><?= number_format($current_data['bo']['output']); ?></td>
            <td class="text-center"><?= number_format($current_data['dmi']['output']); ?></td>
            <td class="text-center"><?= number_format($current_data['piano']['output']); ?></td>
            <td class="text-center"><?= number_format($current_data['other']['output']); ?></td>
        </tr>
        <tr>
            <td>> POST PROCESS ( NG QTY )</td>
            <td class="text-center"><?= number_format($current_data['all']['ng_post']); ?></td>
            <td class="text-center"><?= number_format($current_data['av']['ng_post']); ?></td>
            <td class="text-center"><?= number_format($current_data['pa']['ng_post']); ?></td>
            <td class="text-center"><?= number_format($current_data['sn']['ng_post']); ?></td>
            <td class="text-center"><?= number_format($current_data['bo']['ng_post']); ?></td>
            <td class="text-center"><?= number_format($current_data['dmi']['ng_post']); ?></td>
            <td class="text-center"><?= number_format($current_data['piano']['ng_post']); ?></td>
            <td class="text-center"><?= number_format($current_data['other']['ng_post']); ?></td>
        </tr>
        <tr>
            <td>> SELF PROCESS ( NG QTY )</td>
            <td class="text-center"><?= number_format($current_data['all']['ng_self']); ?></td>
            <td class="text-center"><?= number_format($current_data['av']['ng_self']); ?></td>
            <td class="text-center"><?= number_format($current_data['pa']['ng_self']); ?></td>
            <td class="text-center"><?= number_format($current_data['sn']['ng_self']); ?></td>
            <td class="text-center"><?= number_format($current_data['bo']['ng_self']); ?></td>
            <td class="text-center"><?= number_format($current_data['dmi']['ng_self']); ?></td>
            <td class="text-center"><?= number_format($current_data['piano']['ng_self']); ?></td>
            <td class="text-center"><?= number_format($current_data['other']['ng_self']); ?></td>
        </tr>
        <tr>
            <td>> PRE PROCESS ( NG QTY )</td>
            <td class="text-center"><?= number_format($current_data['all']['ng_pre']); ?></td>
            <td class="text-center"><?= number_format($current_data['av']['ng_pre']); ?></td>
            <td class="text-center"><?= number_format($current_data['pa']['ng_pre']); ?></td>
            <td class="text-center"><?= number_format($current_data['sn']['ng_pre']); ?></td>
            <td class="text-center"><?= number_format($current_data['bo']['ng_pre']); ?></td>
            <td class="text-center"><?= number_format($current_data['dmi']['ng_pre']); ?></td>
            <td class="text-center"><?= number_format($current_data['piano']['ng_pre']); ?></td>
            <td class="text-center"><?= number_format($current_data['other']['ng_pre']); ?></td>
        </tr>
    </tbody>
</table>

<table class="table summary-tbl">
    <thead>
        <tr>
            <th>DEFECT RATIO - FINAL ASSY ( ALL MODEL )</th>
            <?php foreach ($period_arr as $period): ?>
                <th class="text-center"><?= date('M', strtotime($period . '01')); ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>OUTPUT</td>
            <?php foreach ($data as $key => $value): ?>
                <td class="text-center"><?= number_format($value['all']['output']); ?></th>
            <?php endforeach ?>
        </tr>
        <tr>
            <td>DEFECT SELF + POST</td>
            <?php foreach ($data as $key => $value): ?>
                <td class="text-center"><?= number_format($value['all']['ng_self'] + $value['all']['ng_post']); ?></th>
            <?php endforeach ?>
        </tr>
        <tr>
            <td>RATIO</td>
            <?php
            $data_series = $tmp_data_series = $tmp_target = [];
            foreach ($data as $key => $value):
                $total_ng = $value['all']['ng_self'] + $value['all']['ng_post'];
                $total_output = $value['all']['output'];
                $tmp_ratio = 0;
                if ($total_output > 0) {
                    $tmp_ratio = round(($total_ng / $total_output) * 100, 3);
                }
                $tmp_data_series[] = [
                    'y' => $tmp_ratio,
                ];
                $tmp_target[] = [
                    'y' => $target,
                ];
                ?>
                <td class="text-center"><?= $value['all']['output'] == 0 ? 0 : round((($value['all']['ng_self'] + $value['all']['ng_post']) / $value['all']['output']) * 100, 3); ?>%</th>
            <?php endforeach;
            $data_series = [
                [
                    'name' => 'DEFECT RATIO',
                    'data' => $tmp_data_series
                ],
                [
                    'name' => 'TARGET',
                    'data' => $tmp_target,
                    'color' => 'red'
                ],
            ];
            ?>
        </tr>
        <tr>
            <td>TARGET</td>
            <?php foreach ($period_arr as $period): ?>
                <td class="text-center"><?= $target; ?>%</th>
            <?php endforeach ?>
        </tr>
    </tbody>
</table>

<div class="panel panel-primary">
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                //'themes/grid-light',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'line',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    //'height' => 500
                ],
                'title' => [
                    'text' => 'DEFECT RATIO - FA',
                ],
                'subtitle' => [
                    'text' => null
                ],
                'xAxis' => [
                    'categories' => $period_arr,
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Defect Ratio (%)'
                    ],
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    //'shared' => true,
                    //'xDateFormat' => '%A, %b %e %Y',
                    'valueSuffix' => '%'
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'series' => [
                        'dataLabels' => [
                            'enabled' => true
                        ],
                        
                    ]
                ],
                'series' => $data_series
            ],
        ]);
        ?>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                //'themes/grid-light',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'line',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    //'height' => 500
                ],
                'title' => [
                    'text' => ' DAILY DEFECT RATIO - FA',
                ],
                'subtitle' => [
                    'text' => null
                ],
                'xAxis' => [
                    'type' => 'datetime',
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Defect Ratio (%)'
                    ],
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    'shared' => true,
                    //'xDateFormat' => '%A, %b %e %Y',
                    'valueSuffix' => '%'
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'series' => [
                        'dataLabels' => [
                            'enabled' => true
                        ],
                        
                    ]
                ],
                'series' => $data_daily_ratio
            ],
        ]);
        ?>
        <table class="summary-tbl table table-responsive" style="display: block; overflow-x: auto; white-space: nowrap;">
            <thead>
                <tr>
                    <th></th>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <th class="text-center" style="font-size: 12px; min-width: 65px;"><?= date('d', strtotime($key)); ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>OUTPUT QTY</td>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <td class="text-center" style="font-size: 12px;"><?= number_format($value['all']); ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>POST PROCESS ( NG QTY )</td>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <td class="text-center" style="font-size: 12px;"><?= number_format($value['ng_post']); ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>SELF PROCESS ( NG QTY )</td>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <td class="text-center" style="font-size: 12px;"><?= number_format($value['ng_self']); ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>PRE PROCESS ( NG QTY )</td>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <td class="text-center" style="font-size: 12px;"><?= number_format($value['ng_pre']); ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>SELF + POST PROCESS ( NG QTY )</td>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <td class="text-center" style="font-size: 12px;"><?= number_format($value['ng_self_post']); ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>POST PROCESS ( DEFECT RATIO )</td>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <td class="text-center" style="font-size: 12px;"><?= $value['post_ratio']; ?>%</td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>SELF PROCESS ( DEFECT RATIO )</td>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <td class="text-center" style="font-size: 12px;"><?= $value['self_ratio']; ?>%</td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>PRE PROCESS ( DEFECT RATIO )</td>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <td class="text-center" style="font-size: 12px;"><?= $value['pre_ratio']; ?>%</td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>SELF + POST PROCESS ( DEFECT RATIO )</td>
                    <?php foreach ($data_table_daily_ratio as $key => $value): ?>
                        <td class="text-center" style="font-size: 12px;"><?= $value['self_post_ratio']; ?>%</td>
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>