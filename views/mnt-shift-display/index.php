<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Maintenance Shift Data <small>' . $today .'</small><span class="japanesse text-green"></span>',
    'tab_title' => 'Maintenance Shift Data',
    'breadcrumbs_title' => 'Maintenance Shift Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    //.box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 20px;}
    .container {width: auto;}
    .content-header>h1 {font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .panel-title {font-size: 40px; text-align: center;}
    dl {font-size: 18px; margin-top: 10px; margin-left: 25px;}
");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

?>
<div class="row">
    <div class="col-md-4">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h4 class="box-title">SHIFT 1</h4>
            </div>
            <div class="box-body">
                <div class="box-group" id="accordion1">
                    <?php
                    if (isset($data[1]) && $data[1] != null) {
                        foreach ($data[1] as $key => $value) {
                            ?>
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#collapse_<?= $value['nik']; ?>" aria-expanded="false" class="collapsed">
                                    <?= $value['name']; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse_<?= $value['nik']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="box-body">
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <div class="pull-left image">
                                                <?php
                                                $filename = $value['nik'] . '.jpg';
                                                $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                                                if (file_exists($path)) {
                                                    echo Html::img('@web/uploads/yemi_employee_img/' . $value['nik'] . '.jpg', [
                                                        'class' => 'img-circle',
                                                        'style' => 'object-fit: cover; height: 80px; width: 80px; border: 3px solid #d0d0d0;'
                                                    ]);
                                                } else {
                                                    echo Html::img('@web/uploads/profpic_02.png', [
                                                        'class' => 'img-circle',
                                                        'style' => 'object-fit: cover; height: 80px; width: 80px; border: 3px solid #d0d0d0;'
                                                    ]);
                                                }
                                                ?>
                                            </div>
                                            <div class="pull-left info">
                                                <dl>
                                                    <dt>Speed Dial </dt>
                                                    <dd>
                                                        <?= $value['speed_dial'] . ' <small>(' . $value['phone'] . ')</small>'; ?>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    }
                    ?>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h4 class="box-title">SHIFT 2</h4>
            </div>
            <div class="box-body">
                <div class="box-group" id="accordion2">
                    <?php
                    if (isset($data[2]) && $data[2] != null) {
                        foreach ($data[2] as $key => $value) {
                            ?>
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapse_<?= $value['nik']; ?>" aria-expanded="false" class="collapsed">
                                    <?= $value['name']; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse_<?= $value['nik']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="box-body">
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <div class="pull-left image">
                                                <?php
                                                $filename = $value['nik'] . '.jpg';
                                                $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                                                if (file_exists($path)) {
                                                    echo Html::img('@web/uploads/yemi_employee_img/' . $value['nik'] . '.jpg', [
                                                        'class' => 'img-circle',
                                                        'style' => 'object-fit: cover; height: 80px; width: 80px; border: 3px solid #d0d0d0;'
                                                    ]);
                                                } else {
                                                    echo Html::img('@web/uploads/profpic_02.png', [
                                                        'class' => 'img-circle',
                                                        'style' => 'object-fit: cover; height: 80px; width: 80px; border: 3px solid #d0d0d0;'
                                                    ]);
                                                }
                                                ?>
                                            </div>
                                            <div class="pull-left info">
                                                <dl>
                                                    <dt>Speed Dial </dt>
                                                    <dd>
                                                        <?= $value['speed_dial'] . ' <small>(' . $value['phone'] . ')</small>'; ?>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <?php 
                        }
                    }
                    ?>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h4 class="box-title">SHIFT 3</h4>
            </div>
            <div class="box-body">
                <div class="box-group" id="accordion3">
                    <?php
                    if (isset($data[3]) && $data[3] != null) {
                        foreach ($data[3] as $key => $value) {
                            ?>
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion3" href="#collapse_<?= $value['nik']; ?>" aria-expanded="false" class="collapsed">
                                    <?= $value['name']; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse_<?= $value['nik']; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="box-body">
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <div class="pull-left image">
                                                <?php
                                                $filename = $value['nik'] . '.jpg';
                                                $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                                                if (file_exists($path)) {
                                                    echo Html::img('@web/uploads/yemi_employee_img/' . $value['nik'] . '.jpg', [
                                                        'class' => 'img-circle',
                                                        'style' => 'object-fit: cover; height: 80px; width: 80px; border: 3px solid #d0d0d0;'
                                                    ]);
                                                } else {
                                                    echo Html::img('@web/uploads/profpic_02.png', [
                                                        'class' => 'img-circle',
                                                        'style' => 'object-fit: cover; height: 80px; width: 80px; border: 3px solid #d0d0d0;'
                                                    ]);
                                                }
                                                ?>
                                            </div>
                                            <div class="pull-left info">
                                                <dl>
                                                    <dt>Speed Dial </dt>
                                                    <dd>
                                                        <?= $value['speed_dial'] . ' <small>(' . $value['phone'] . ')</small>'; ?>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    } else {
                        echo '<span style="color: #3c8dbc; font-size: 20px">There is no employee on Shift 3 ...</span>';
                    }
                    ?>
                </div>
                
            </div>
        </div>
    </div>
</div>