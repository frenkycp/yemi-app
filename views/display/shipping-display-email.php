<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'Shipping Progress <span class="japanesse light-green">(出荷進捗)</span>',
    'tab_title' => 'Shipping Progress',
    'breadcrumbs_title' => 'Shipping Progress'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 1.5em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5; font-family: 'Open Sans', sans-serif;}
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

$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

/*$script = "
    $('document').ready(function() {
        $('#popup-tbl').DataTable({
            'order': [[ 6, 'desc' ]]
        });
    });
";
$this->registerJs($script, View::POS_HEAD );*/

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

$this->registerJs("$(function() {
   $('.popup_btn').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
     $('#popup-tbl').DataTable({
        'order': [[ 6, 'desc' ]]
    });
   });
});");
// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($data_table);
echo '</pre>';*/
?>
<table class="table summary-tbl" style="margin-top: 20px;">
    <thead>
        <tr>
            <th></th>
            <th class="text-center">TOTAL</th>
            <th class="text-center">TARGET</th>
            <th class="text-center">ACTUAL</th>
        </tr>
    </thead>
    <tbody>
        <tr style="display: none;">
            <td>
                <span><b>SHIPPING PROGRESS (N-1)</b></span><br/>
                <span class="japanesse light-green">先日の出荷分</span><span> KEMARIN</span>
            </td>
            <td style="font-size: 5em; text-align: right;"><span><?= $data_table[0]['total_container']; ?></span> <span style="font-size: 0.2em; font-weight: bold;">CNT</span></td>
            <td style="font-size: 5em; text-align: right;"><span><?= number_format($data_table[0]['plan']); ?></span> <span style="font-size: 0.2em; font-weight: bold;">SET</span></td>
            <td style="font-size: 5em; text-align: right;"><span class="<?= $data_table[0]['balance'] < 0 ? 'text-red' : ''; ?>"><?= number_format($data_table[0]['balance']); ?></span> <span style="font-size: 0.2em; font-weight: bold;">SET</span></td>
        </tr>
        <tr>
            <td>
                <span><b>SHIPPING PROGRESS (N)</b></span><br/>
                <span class="japanesse light-green">本日の出荷分</span><span> HARI INI</span>
            </td>
            <td style="font-size: 5em; text-align: right;"><span><?= $data_table[1]['total_container']; ?></span> <span style="font-size: 0.2em; font-weight: bold;">CNT</span></td>
            <td style="font-size: 5em; text-align: right;"><span><?= number_format($data_table[1]['plan']); ?></span> <span style="font-size: 0.2em; font-weight: bold;">SET</span></td>
            <td style="font-size: 5em; text-align: right;"><span class="<?= $data_table[1]['balance'] < 0 ? 'text-red' : ''; ?>"><?= number_format($data_table[1]['balance']); ?></span> <span style="font-size: 0.2em; font-weight: bold;">SET</span></td>
        </tr>
        <tr>
            <td>
                <span><b>SHIPPING PROGRESS (N+1)</b></span><br/>
                <span class="japanesse light-green">翌日の出荷分</span><span> BESOK</span>
            </td>
            <td style="font-size: 5em; text-align: right;"><span><?= $data_table[2]['total_container']; ?></span> <span style="font-size: 0.2em; font-weight: bold;">CNT</span></td>
            <td style="font-size: 5em; text-align: right;"><span><?= number_format($data_table[2]['plan']); ?></span> <span style="font-size: 0.2em; font-weight: bold;">SET</span></td>
            <td style="font-size: 5em; text-align: right;"><span class="<?= $data_table[2]['balance'] < 0 ? 'text-red' : ''; ?>"><?= number_format($data_table[2]['balance']); ?></span> <span style="font-size: 0.2em; font-weight: bold;">SET</span></td>
        </tr>
    </tbody>
</table>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $containerStr; ?></h3>
    </div>
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/dark-unica',
                //'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 400,
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => 'Container Progress (TODAY)'
                ],
                'xAxis' => [
                    'type' => 'category'
                ],
                'xAxis' => [
                    'categories' => $dataName,
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Total Completion'
                    ],
                    'gridLineWidth' => 0,
                ],
                'tooltip' => [
                    //'enabled' => false
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                            'style' => [
                                //'fontSize' => '14px',
                                'fontWeight' => '0',
                                'color' => 'black',
                            ],
                        ],
                        'borderWidth' => 2,
                        'borderColor' => $color,
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ]
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Outstanding',
                        'data' => $dataOpen,
                        'color' => 'FloralWhite',
                        'dataLabels' => [
                            'enabled' => true,
                            'color' => $font_color,
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                        ],
                        //'showInLegend' => false
                    ],
                    [
                        'name' => 'Completed',
                        'data' => $dataClose,
                        'color' => $color,
                        'dataLabels' => [
                            'enabled' => true,
                            'color' => $font_color,
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                        ]
                    ]
                ]
            ],
        ]);
        ?>
    </div>
</div>
<span style="color: white; font-size: 2em;"><span class="japanesse">主な遅れ製品</span>  (Top Minus xxxx ) </span>
<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="text-center top-minus-text" width="100px;">NO.</th>
            <th class="text-center top-minus-text">GMC</th>
            <th class="top-minus-text">DESCRIPTION</th>
            <th class="text-center top-minus-text" width="150px;">PLAN</th>
            <th class="text-center top-minus-text" width="150px;">ACTUAL</th>
            <th class="text-center top-minus-text" width="150px;">BALANCE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($top_minus) == 0) {
            echo '<tr>
                <td colspan="6">No Minus...</td>
            </tr>';
        } else {
            ?>
            <?php
            $no = 0;
            foreach ($top_minus as $value): 
                $no++;
                ?>
                <tr>
                    <td class="text-center top-minus-text"><?= $no; ?></td>
                    <td class="text-center top-minus-text"><?= $value->gmc; ?></td>
                    <td class="top-minus-text"><?= $value->gmc_desc . ' ' . $value->gmc_destination; ?></td>
                    <td class="text-center top-minus-text"><?= number_format($value->qty); ?></td>
                    <td class="text-center top-minus-text"><?= number_format($value->output); ?></td>
                    <td class="text-center top-minus-text text-red"><?= number_format($value->balance); ?></td>
                </tr>
            <?php endforeach ?>
        <?php }
        ?>
    </tbody>
</table>
<span style="color: silver; font-size: 1.2em;"><i>Last Update : <?= date('Y-m-d H:i:s'); ?></i></span>