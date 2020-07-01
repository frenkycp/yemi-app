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
    'page_title' => 'Last Backup <span class="japanesse light-green"></span>',
    'tab_title' => 'Last Backup',
    'breadcrumbs_title' => 'Last Backup'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.4em; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5; font-family: Arial, Helvetica, sans-serif;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .info-box {
        color: white;
    }
    .info-box-icon {
        font-size: 180px;
        height: 250px;
        width: 250px;
        line-height: 270px;
    }
    .info-box-content {
        line-height: 250px;
        margin-left: 250px;
        height: 250px;
        background-color: rgba(0, 0, 0, 0.8);
    }
    .info-box-text {
        font-size: 120px;
        //text-align: center;
        line-height: unset;
        letter-spacing: 5px;
        font-weight: bold;
        padding-left: 30px;
    }
    .info-box-number {
        text-align: center;
        font-style: italic;
        font-weight: normal;
        vertical-align: bottom;
        line-height: 0px;
        color: grey;
        display: none;
    }
");

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
print_r($db_arr);
echo '</pre>';*/
?>
<div class="row" style="padding: 30px;">
<?php foreach ($db_arr as $key => $value): ?>
    
    <div class="col-md-12" style="padding-bottom: 30px;">
        <div class="info-box">
            <?php
            if ($value['total'] > 0) {
                echo '<span class="info-box-icon bg-green"><i class="fa fa-calendar-check-o"></i></span>';
            } else {
                echo '<span class="info-box-icon bg-red"><i class="fa fa-calendar-times-o"></i></span>';
            }
            ?>

            <div class="info-box-content">
                <span class="info-box-text"><?= str_replace('-', ' ', $value['database_name']); ?></span>
                <span class="info-box-number">Last Update : <?= date('Y-m-d H:i:s', strtotime($value['last_backup'])); ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    
<?php endforeach ?>
</div>