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
    'page_title' => 'Rekap Absensi Harian <span class="japanesse light-green"></span>',
    'tab_title' => 'Rekap Absensi Harian',
    'breadcrumbs_title' => 'Rekap Absensi Harian'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



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

    #summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 22px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    #summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: yellow;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    //tbody > tr > td { background: #33383d;}
    #summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
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

/*echo '<pre>';
print_r($tmp_today_arr);
echo '</pre>';
echo '<pre>';
print_r($total_plan_arr);
echo '</pre>';
echo '<pre>';
print_r($total_actual_arr);
echo '</pre>';*/
?>

<br/>
<div id="pagewrap" class="pagewrap">
    <div class="container show">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            //'layout' => 'horizontal',
            'action' => Url::to(['rekap-absensi-harian']),
        ]); ?>

        <div class="row" style="width: 200px;">
            <div class="col-md-12">
                <?= $form->field($model, 'post_date')->widget(DatePicker::classname(), [
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => [
                        'placeholder' => 'Enter date ...',
                        'class' => 'form-control text-center',
                        'onchange'=>'this.form.submit()',
                    ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])->label(false); ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        <table id="summary-tbl" class="table table-responsive">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th>Detail</th>
                    <th class="text-center">Shift 3</th>
                    <th class="text-center">Shift 1</th>
                    <th class="text-center">Shift 2</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                $grandtotal_plan = $total_plan_arr[1] + $total_plan_arr[2] + $total_plan_arr[3];
                $grandtotal_actual = $total_actual_arr[1] + $total_actual_arr[2] + $total_actual_arr[3];
                foreach ($tmp_today_arr as $key => $row): 
                    $no++;
                    if ($key == 'P') {
                        $style_label = 'color: white; text-shadow: -1px -1px 0 #0F0';
                    } else {
                        $style_label = 'color: white; text-shadow: -1px -1px 0 #F00, 1px -1px 0 #F00, -1px 1px 0 #F00, 1px 1px 0 #F00;';
                        if ($key == 'C') {
                            $key = 'C_ALL';
                        }
                    }
                    $tmp_total = 0;
                    $tmp_total = $row[3] + $row[1] + $row[2];
                    $tmp_percentage = 0;
                    if ($grandtotal_plan > 0) {
                        $tmp_percentage = round(($tmp_total / $grandtotal_plan) * 100, 1);
                    }
                    ?>
                    <tr>
                        <td class="text-center"><?= $no; ?></td>
                        <td><?= $row['title']; ?></td>
                        <td class="text-center"><?= $row[3] == 0 ? $row[3] : Html::a(number_format($row[3]), ['/sunfish-attendance-data', 'post_date' => $model->post_date, 'shift' => 3, 'attend_judgement' => $key], ['target' => '_blank', 'style' => $style_label]); ?></td>
                        <td class="text-center"><?= $row[1] == 0 ? $row[1] : Html::a(number_format($row[1]), ['/sunfish-attendance-data', 'post_date' => $model->post_date, 'shift' => 1, 'attend_judgement' => $key], ['target' => '_blank', 'style' => $style_label]); ?></td>
                        <td class="text-center"><?= $row[2] == 0 ? $row[2] : Html::a(number_format($row[2]), ['/sunfish-attendance-data', 'post_date' => $model->post_date, 'shift' => 2, 'attend_judgement' => $key], ['target' => '_blank', 'style' => $style_label]); ?></td>
                        <td class="text-center"><?= number_format($tmp_total); ?></td>
                        <td class="text-center"><?= $tmp_percentage . '%'; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-right">Total Aktual</td>
                    <td class="text-center"><?= number_format($total_actual_arr[3]); ?></td>
                    <td class="text-center"><?= number_format($total_actual_arr[1]); ?></td>
                    <td class="text-center"><?= number_format($total_actual_arr[2]); ?></td>
                    <td class="text-center"><?= number_format($grandtotal_actual); ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">Total Plan</td>
                    <td class="text-center"><?= number_format($total_plan_arr[3]); ?></td>
                    <td class="text-center"><?= number_format($total_plan_arr[1]); ?></td>
                    <td class="text-center"><?= number_format($total_plan_arr[2]); ?></td>
                    <td class="text-center"><?= number_format($grandtotal_plan); ?></td>
                </tr>
            </tfoot>
        </table>
        <div class="box box-primary box-solid">
            <div class="box-body">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        //'modules/exporting',
                        //'themes/sand-signika',
                        //'themes/grid-light',
                        'themes/dark-unica',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'column',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'zoomType' => 'x',
                            'height' => 300
                        ],
                        'title' => [
                            'text' => 'Total Karyawan Harian'
                        ],
                        'subtitle' => [
                            'text' => ''
                        ],
                        'xAxis' => [
                            'type' => 'datetime',
                            'tickInterval' => 1000 * 60 * 60 * 24,
                            //'categories' => $value['category'],
                        ],
                        'yAxis' => [
                            //'min' => 0,
                            'title' => [
                                'text' => null
                            ],
                            'allowDecimals' => false,
                            //'gridLineWidth' => 0,
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'tooltip' => [
                            'enabled' => true,
                            //'xDateFormat' => '%A, %b %e %Y',
                            //'valueSuffix' => ' min'
                            //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                        ],
                        'plotOptions' => [
                            'series' => [
                                /*'marker' => [
                                    'enabled' => false
                                ],*/
                                'dataLabels' => [
                                    'enabled' => true
                                ],
                                /*'lineWidth' => 1,
                                'marker' => [
                                    'radius' => 2,
                                ],*/
                                'cursor' => 'pointer',
                                'point' => [
                                    'events' => [
                                        'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    ]
                                ]
                            ]
                        ],
                        'series' => $data_daily_arr
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
    <div id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <!------------------- ANIMASI ------------------------->
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none" > <!------------------- ANIMASI ------------------------->
            <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/> <!------------------- ANIMASI ------------------------->
        </svg> <!------------------- ANIMASI ------------------------->
    </div>
</div>