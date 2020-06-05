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
    'page_title' => 'Daily Attendance Summary <span class="japanesse light-green"></span>',
    'tab_title' => 'Daily Attendance Summary',
    'breadcrumbs_title' => 'Daily Attendance Summary'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.4em; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
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
print_r($tmp_data);
echo '</pre>';*/
?>



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
            <tbody id="table-container">
                <?php
                $no = 0;
                $total_shift1 = $total_shift2 = $total_shift3 = 0;
                $plan_shift1 = $plan_shift2 = $plan_shift3 = 0;
                foreach ($data as $row):
                    ?>
                    <?php
                    if ($row['title'] == 'MP') {
                        $plan_shift1 = $row['shift1'];
                        $plan_shift2 = $row['shift2'];
                        $plan_shift3 = $row['shift3'];
                    } else { 
                        $no++;
                        $total_shift1 += $row['shift1'];
                        $total_shift2 += $row['shift2'];
                        $total_shift3 += $row['shift3'];

                        if ($row['code'] == 'P') {
                            $style_label = 'color: white; text-shadow: -1px -1px 0 #0F0';
                        } else {
                            $style_label = 'color: white; text-shadow: -1px -1px 0 #F00, 1px -1px 0 #F00, -1px 1px 0 #F00, 1px 1px 0 #F00;';
                        }
                        ?>
                        <tr>
                            <td class="text-center"><?= $no; ?></td>
                            <td><?= $row['title']; ?></td>
                            <td class="text-center"><?= $row['shift3'] == 0 ? $row['shift3'] : Html::a(number_format($row['shift3']), ['/sunfish-attendance-data', 'post_date' => $model->post_date, 'shift' => 3, 'attend_judgement' => $row['code']], ['target' => '_blank', 'style' => $style_label]); ?></td>
                            <td class="text-center"><?= $row['shift1'] == 0 ? $row['shift1'] : Html::a(number_format($row['shift1']), ['/sunfish-attendance-data', 'post_date' => $model->post_date, 'shift' => 1, 'attend_judgement' => $row['code']], ['target' => '_blank', 'style' => $style_label]); ?></td>
                            <td class="text-center"><?= $row['shift2'] == 0 ? $row['shift2'] : Html::a(number_format($row['shift2']), ['/sunfish-attendance-data', 'post_date' => $model->post_date, 'shift' => 2, 'attend_judgement' => $row['code']], ['target' => '_blank', 'style' => $style_label]); ?></td>
                            <td class="text-center"><?= number_format($row['total']); ?></td>
                            <td class="text-center"><?= $row['title'] == 'MP' ? '' : $row['percentage'] . '%'; ?></td>
                        </tr>
                    <?php }
                    ?>
                <?php endforeach ?>
                <?php
                $grandtotal_actual = $total_shift1 + $total_shift2 + $total_shift3;
                $grandtotal_plan = $plan_shift1 + $plan_shift2 + $plan_shift3;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-right">Total Aktual</td>
                    <td class="text-center"><?= number_format($total_shift3); ?></td>
                    <td class="text-center"><?= number_format($total_shift1); ?></td>
                    <td class="text-center"><?= number_format($total_shift2); ?></td>
                    <td class="text-center"><?= number_format($grandtotal_actual); ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">Total Plan</td>
                    <td class="text-center"><?= number_format($plan_shift3); ?></td>
                    <td class="text-center"><?= number_format($plan_shift1); ?></td>
                    <td class="text-center"><?= number_format($plan_shift2); ?></td>
                    <td class="text-center"><?= number_format($grandtotal_plan); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <!------------------- ANIMASI ------------------------->
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none" > <!------------------- ANIMASI ------------------------->
            <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/> <!------------------- ANIMASI ------------------------->
        </svg> <!------------------- ANIMASI ------------------------->
    </div>
</div>