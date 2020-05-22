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
    'page_title' => 'PRINTER USAGE (OPEN) <span class="japanesse light-green"></span>',
    'tab_title' => 'PRINTER USAGE (OPEN)',
    'breadcrumbs_title' => 'PRINTER USAGE (OPEN)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCssFile('@web/css/component.css');
$this->registerJsFile('@web/js/snap.svg-min.js');
$this->registerJsFile('@web/js/classie.js');
$this->registerJsFile('@web/js/svgLoader.js');

$this->registerCss("
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

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 18px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        font-size: 16px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 100px;
    }
    tbody > tr > td { background: #33383d;}
    tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}
    .top-tree {font-size: 2em !important; color : black !important; background-color: yellow !important;}
");

$no = 0;
$script = "
    window.onload = setupRefresh;

    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['printer-usage-update', 'is_admin' => $is_admin]) . "',
            success: function(data){
                var tmp_data = JSON.parse(data);
                $('#table-container').html(tmp_data.table_container);
                $('#last-update').html(tmp_data.last_update);
            },
            complete: function(){
                setTimeout(function(){update_data();}, 3000);
            }
        });
    }

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 60000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    function animation_page(){
        loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 700, easingIn : mina.easeinout } ); //------------------- ANIMASI -------------------------
        function init() //------------------- ANIMASI -------------------------
        { //------------------- ANIMASI -------------------------
            loader.show(); //------------------- ANIMASI -------------------------
            setTimeout( function() { loader.hide(); }, 700 ); //------------------- ANIMASI -------------------------
        } //------------------- ANIMASI -------------------------

        init(); //------------------- ANIMASI -------------------------
    };
    $(document).ready(function() {
        update_data();
        animation_page();
    });
";
$this->registerJs($script, View::POS_HEAD );
if ($is_admin != 1) {
    
}


/*echo '<pre>';
print_r($data_nolog);
echo '</pre>';*/

?>
<div id="pagewrap" class="pagewrap">
    <div class="container show">
        <div id="marquee-container">
            <marquee behavior="alternate" scrollamount="12" style="background-color: #61258e; color: yellow; font-size: 3em;"><?= strtoupper('Go Smart! Go Paperless! Print hanya yang dibutuhkan...') ?></marquee>
        </div>
        <span style="color: white;" id="last-update">Last Update : <?= date('Y-m-d H:i:s'); ?></span>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th class="text-center" style="<?= $is_admin == 1 ? '' : 'display: none;'; ?>">Act.</th>
                    <th class="text-center" width="50px">No.</th>
                    <th class="text-center" width="120px">XEROX</th>
                    <th class="text-center" width="100px">Job Type</th>
                    <th class="text-center" width="100px">Ink Type</th>
                    <th class="text-center" width="200px">Username</th>
                    <th class="text-center" width="160px">Completed Time</th>
                    <th>Job Name</th>
                </tr>
            </thead>
            <tbody id="table-container">
                <?php foreach ($tmp_list as $value): 
                    $no++;
                    ?>
                    <tr>
                        <td class="text-center<?= $no <= 3 ? ' top-tree' : ''; ?>" width="50px" style="<?= $is_admin == 1 ? '' : 'display: none;'; ?>"><?= Html::a('<i class="glyphicon glyphicon-check"></i>', ['printer-usage-close', 'seq' => $value->seq], [
                            'title' => 'Close Job',
                            'data-confirm' => 'Are you sure to close this job ?'
                            ]); ?></td>
                        <td class="text-center<?= $no <= 3 ? ' top-tree' : ''; ?>"><?= $no; ?></td>
                        <td class="text-center<?= $no <= 3 ? ' top-tree' : ''; ?>"><?= $value->machine_ip; ?></td>
                        <td class="text-center<?= $no <= 3 ? ' top-tree' : ''; ?>"><?= $value->job_type; ?></td>
                        <td class="text-center<?= $no <= 3 ? ' top-tree' : ''; ?>"><?= $value->color; ?></td>
                        <td class="text-center<?= $no <= 3 ? ' top-tree' : ''; ?>"><?= $value->user_name; ?></td>
                        <td class="text-center<?= $no <= 3 ? ' top-tree' : ''; ?>"><?= date('Y-m-d H:i:s', strtotime($value->completed_time)); ?></td>
                        <td class="<?= $no <= 3 ? 'top-tree' : ''; ?>"><?= $value->job_name; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <!------------------- ANIMASI ------------------------->
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none" > <!------------------- ANIMASI ------------------------->
            <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/> <!------------------- ANIMASI ------------------------->
        </svg> <!------------------- ANIMASI ------------------------->
    </div>
</div>
