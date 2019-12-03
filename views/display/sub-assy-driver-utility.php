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
    'page_title' => 'Sub Assy Driver Utility <span class="japanesse light-green"></span>',
    'tab_title' => 'Sub Assy Driver Utility',
    'breadcrumbs_title' => 'Sub Assy Driver Utility'
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
");

date_default_timezone_set('Asia/Jakarta');

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
//print_r($tmp_data);

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<div class="row">
    <?php foreach ($data as $key => $value): ?>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $key ?></h3>
                </div>
                <div class="panel-body">
                    <?php foreach ($value['operator'] as $key => $operator): ?>
                        <?php
                        if ($operator['utility'] < 60) {
                            $btn_class = 'btn btn-danger';
                        } else {
                            $btn_class = 'btn btn-success';
                        }
                        ?>
                        <span title="Utility : <?= $operator['utility']; ?>%" style="font-size: 1.2em; margin: 3px 1px;" class="<?= $btn_class; ?>"><?= $operator['nik']; ?></span>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>