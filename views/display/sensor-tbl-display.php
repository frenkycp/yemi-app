<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\CutiTblSearch $searchModel
*/

$this->title = [
    'page_title' => 'Temperature & Humidity Data Table <span class="japanesse text-green"></span>',
    'tab_title' => 'Temperature & Humidity Data Table',
    'breadcrumbs_title' => 'Temperature & Humidity Data Table'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    //.container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}

    #progress-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    th{
        vertical-align: middle !important;
        font-weight: normal;
    }
    #progress-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 28px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
    }
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 60000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['display/sensor-tbl-display']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'factory')->dropDownList(
            [
                'Factory #1' => 'Factory #1',
                'Factory #2' => 'Factory #2',
            ], [
                'onchange'=>'this.form.submit()',
            ]
        ); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="panel panel-primary">
    <div class="panel-body no-padding">
        <table class="table table-responsive table-bordered table-striped" style="font-size: 1.2em;">
            <thead>
                <tr class="bg-light-blue">
                    <th rowspan="2" class="text-center">No.</th>
                    <th rowspan="2" class="text-center">Area</th>
                    <th colspan="3" class="text-center">Temperature (&deg;C)</th>
                    <th colspan="3" class="text-center">Humidity (%)</th>
                </tr>
                <tr class="bg-light-blue">
                    <th class="text-center">Min</th>
                    <th class="text-center">Max</th>
                    <th class="text-center">Actual</th>
                    <th class="text-center">Min</th>
                    <th class="text-center">Max</th>
                    <th class="text-center">Actual</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data as $key => $value) {
                    $temp_class = '';
                    $txt_temp_class = $txt_humi_class = '';
                    if ($value['temp_min'] != null && $value['temp_max'] != null) {
                        if ($value['temparature'] < $value['temp_min'] || $value['temparature'] > $value['temp_max']) {
                            $temp_class = 'danger';
                            $txt_temp_class = ' text-red';
                        }
                    }
                    if ($value['humi_min'] != null && $value['humi_max'] != null) {
                        if ($value['humidity'] < $value['humi_min'] || $value['humidity'] > $value['humi_max']) {
                            $temp_class = 'danger';
                            $txt_humi_class = ' text-red';
                        }
                    }
                    ?>
                    <tr class="<?= $temp_class; ?>">
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $value['area']; ?></td>
                        <td class="text-center"><?= $value['temp_min'] == null ? '<em style="color: silver;" class="">(Not Set)</em>' : number_format($value['temp_min']); ?></td>
                        <td class="text-center"><?= $value['temp_max'] == null ? '<em style="color: silver;" class="">(Not Set)</em>' : number_format($value['temp_max']); ?></td>
                        <td class="text-center<?= $txt_temp_class; ?>"><?= $value['temparature'] == null ? '<em style="color: silver;" class="">(Not Set)</em>' : number_format($value['temparature']); ?></td>
                        <td class="text-center"><?= $value['humi_min'] == null ? '<em style="color: silver;" class="">(Not Set)</em>' : number_format($value['humi_min']); ?></td>
                        <td class="text-center"><?= $value['humi_max'] == null ? '<em style="color: silver;" class="">(Not Set)</em>' : number_format($value['humi_max']); ?></td>
                        <td class="text-center<?= $txt_humi_class; ?>"><?= $value['humidity'] == null ? '<em style="color: silver;" class="">(Not Set)</em>' : number_format($value['humidity']); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>