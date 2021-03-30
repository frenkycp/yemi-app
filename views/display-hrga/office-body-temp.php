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
    'page_title' => 'Employee Body Temp. Monitoring <span class="japanesse light-green">社員の体温管理</span>',
    'tab_title' => 'Employee Body Temp. Monitoring',
    'breadcrumbs_title' => 'Employee Body Temp. Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');


$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 1em; text-align: center;}
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

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid black;
        background-color: #7d5685;
        color: white;
        font-size: 20px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .summary-tbl > tbody > tr > td{
        border: 1px solid black;
        font-size: 16px;
        background: #8bd78f;
        color: #000;
        vertical-align: middle;
        //padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
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
    .side-title {
        font-size: 26px;
        color: white;
        letter-spacing: 2px;
        font-weight : bold;
    }
    .temp-over-style {
        background-color: red;
        color: white;
    }
    //tbody > tr > td { background: #33383d;}
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    $(document).ready(function() {
        var i = 0;
        setInterval(function() {
            i++;
            if(i%2 == 0){
                $(".temp-over").css("background-color", "red");
                $(".temp-over").css("color", "white");
            } else {
                $(".temp-over").css("background-color", "#8bd78f");
                $(".temp-over").css("color", "black");
            }
        }, 700);
    });
JS;
$this->registerJs($script, View::POS_END );


/*echo '<pre>';
print_r($tmp_belum_check);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['temperature-daily']),
]); ?>

<div class="row" style="width: 300px; padding-top: 10px;">
    <div class="col-md-12">
        <?= $form->field($model, 'post_date')->widget(DatePicker::classname(), [
            //'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'removeButton' => false,
            'options' => [
                'placeholder' => 'Enter date ...',
                'class' => 'form-control text-center',
                'onchange'=>'this.form.submit()',
                'style' => 'font-size:30px; height: 45px;'
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label(false); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="row">
    <div class="col-sm-5">
        <div class="side-title"><i class="fa fa-caret-right"></i> Cek Status</div>
        <table class="table summary-tbl table-condensed">
            <thead>
                <tr>
                    <th class="text-center">Sudah Cek</th>
                    <th class="text-center">Belum Cek</th>
                </tr>
            </thead>
            <tbody>
                <td class="text-center" style="font-size: 30px;"><b><?= number_format($total_check); ?></b> Person(s)</td>
                <td class="text-center" style="font-size: 30px;"><b><?= number_format($total_no_check); ?></b> Person(s)</td>
            </tbody>
        </table>

        <div class="side-title"><i class="fa fa-caret-right"></i> Detail Cek Suhu ≥ 37.5 &deg;C</div>
        <table class="table summary-tbl table-condensed">
            <thead>
                <tr>
                    <th class="text-center">Karyawan</th>
                    <th class="text-center">Shift</th>
                    <th class="text-center">Temp.</th>
                    <th class="text-center">Check<br/>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($temp_over_data) > 0) {
                    foreach ($temp_over_data as $key => $value) {
                        echo '<tr>
                            <td class="text-center temp-over" style="font-size: 24px;"><b>' . $value['nik'] . '<br/>' . $value['name'] . '</b></td>
                            <td class="text-center temp-over" style="font-size: 24px;"><b>' . $value['shift'] . '</b></td>
                            <td class="text-center temp-over" style="font-size: 24px;"><b>' . $value['temperature'] . '</b></td>
                            <td class="text-center temp-over" style="font-size: 24px;"><b>' . date('d M Y H:i', strtotime($value['last_update'])) . '</b></td>
                        </tr>';
                    }
                } else {
                    echo '<td colspan="4" class="" style="font-weight: bold; padding-left: 10px;">Tidak ada suhu yang ≥ 37.5 &deg;C</td>';
                }
                ?>
                
            </tbody>
        </table>

        <div class="side-title"><i class="fa fa-caret-right"></i> Detail Belum Cek</div>
        <table class="table summary-tbl table-condensed">
            <thead>
                <tr>
                    <th class="text-center" width="60px">#</th>
                    <th class="text-center" width="150px">ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Shift</th>
                    <th class="text-center">Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 0;
                if ($total_no_check == 0) {
                    echo '<tr>
                        <td colspan="4" style="font-weight: bold; padding-left: 5px;">Semua Karyawan Office Sudah Cek Suhu</td>
                    </tr>';
                } else {
                    foreach ($no_check_data2 as $value){
                        if (count($value) > 0) {
                            foreach ($value as $value2) {
                                $no++;
                                ?>
                                <tr>
                                    <td class="text-center" style="font-weight: bold;"><?= $no; ?></td>
                                    <td class="text-center" style="font-weight: bold;"><?= $value2['nik']; ?></td>
                                    <td class="text-center" style="font-weight: bold;"><?= $value2['name']; ?></td>
                                    <td class="text-center" style="font-weight: bold;"><?= $value2['shift']; ?></td>
                                    <td class="text-center" style="font-weight: bold;"><?= $value2['attendance']; ?></td>
                                </tr>
                            <?php }
                        }
                    } 
                } ?>
                
            </tbody>
        </table>

    </div>
    <div class="col-sm-7">
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
                    'height' => 820,
                    'style' => [
                        'fontFamily' => 'sans-serif'
                    ],
                    'backgroundColor' => 'black'
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
                    'categories' => $categories,
                    'labels' => [
                        'style' => [
                            'fontSize' => '26px'
                        ],
                    ],
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => null
                    ],
                ],
                'plotOptions' => [
                    'column' => [
                        'dataLabels' => [
                            'enabled' => true,
                            'style' => [
                                'fontSize' => '36px'
                            ],
                        ]
                    ],
                    'series' => [
                        'pointPadding' => 0.1,
                        'groupPadding' => 0,
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('
                                    function(){
                                        $("#modal").modal("show").find(".modal-content").html(this.options.remark);
                                    }
                                '),
                            ]
                        ]
                    ],
                ],
                'series' => $data_chart
            ],
        ]);
        ?>
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