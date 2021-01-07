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
    //tbody > tr > td { background: #33383d;}
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
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

$script = <<< JS
    $(function() {
        $('#belum_cek_1').click(function () {
            $('#modal_1').modal('show');
        });
        $('#belum_cek_2').click(function () {
            $('#modal_2').modal('show');
        });
        $('#belum_cek_3').click(function () {
            $('#modal_3').modal('show');
        });
    });
JS;

$this->registerJs($script);


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

        <div class="side-title"><i class="fa fa-caret-right"></i> Detail Cek Suhu >= 37.5 &deg;C</div>
        <table class="table summary-tbl table-condensed">
            <thead>
                <tr>
                    <th class="text-center">Karyawan</th>
                    <th class="text-center">Temp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($temp_over_data) > 0) {
                    # code...
                } else {
                    echo '<td colspan="2" class="" style="font-weight: bold; padding-left: 10px;">Tidak ada suhu yang >= 37.5 &deg;C</td>';
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
                    <th class="text-center">Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 0;
                foreach ($no_check_data as $value): 
                    $no++;
                    ?>
                    <tr>
                        <td class="text-center" style="font-weight: bold;"><?= $no; ?></td>
                        <td class="text-center" style="font-weight: bold;"><?= $value['nik']; ?></td>
                        <td class="text-center" style="font-weight: bold;"><?= $value['name']; ?></td>
                        <td class="text-center" style="font-weight: bold;"><?= $value['attendance']; ?></td>
                    </tr>
                <?php endforeach ?>
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
                        'text' => 'Total Person(s)'
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