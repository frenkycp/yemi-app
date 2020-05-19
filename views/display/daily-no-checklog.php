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
    'page_title' => 'No Checklog Summary <span class="japanesse light-green"></span>',
    'tab_title' => 'No Checklog Summary',
    'breadcrumbs_title' => 'No Checklog Summary'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.4em; text-align: center;}
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

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        //font-size: 4em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 100px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 8em;}
");

/*$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );*/
$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#nolog-tbl').DataTable({
        'pageLength': 25,
        'order': [[ 0, 'asc' ], [ 2, 'asc' ]]
    });
});");

/*echo '<pre>';
print_r($data_nolog['B']);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'layout' => 'horizontal',
    'action' => Url::to(['daily-no-checklog']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'post_date')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'options' => [
                'placeholder' => 'Enter date ...',
                'class' => 'form-control',
                'onchange'=>'this.form.submit()',
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label('Date'); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">
                    GROUP A
                </h3>
            </div>
            <div class="panel-body bg-black text-center">
                <span class="total-nolog">
                    <?= count($data_nolog['A']); ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">
                    GROUP B
                </h3>
            </div>
            <div class="panel-body bg-black text-center">
                <span class="total-nolog">
                    <?= count($data_nolog['B']); ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">
                    OTHERS
                </h3>
            </div>
            <div class="panel-body bg-black text-center">
                <span class="total-nolog">
                    <?= count($data_nolog['O']); ?>
                </span>
            </div>
        </div>
    </div>
</div>
<hr>
<div style="width: 50%; margin: auto;">
    <div class="panel panel-primary">
        <div class="panel-body bg-black">
            <table class="table" id="nolog-tbl">
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Group</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_nolog as $key => $value): 
                        if ($key == 'A') {
                            $group_name = 'GROUP_A';
                        } elseif ($key == 'B') {
                            $group_name = 'GROUP_B';
                        } else {
                            $group_name = 'OTHERS';
                        }
                        ?>
                        <?php foreach ($value as $key2 => $value2): ?>
                            <tr>
                                <td><?= $value2['section']; ?></td>
                                <td><?= $value2['nik']; ?></td>
                                <td><?= $value2['name']; ?></td>
                                <td><?= $group_name; ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>