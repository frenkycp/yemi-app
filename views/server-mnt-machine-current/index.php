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
    'page_title' => 'Machine Setting (Current) <span class="japanesse text-green"></span>',
    'tab_title' => 'Machine Setting (Current)',
    'breadcrumbs_title' => 'Machine Setting (Current)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    //.form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; text-align: center;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}

    #progress-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #progress-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #595F66;
        color: white;
        font-size: 20px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #progress-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 20px;
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
      setTimeout(\"refreshPage();\", 10000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

if (isset($current_data['lot_id'])) {
    $this->registerJs("$(function() {
       $('#btn-complete').click(function(e) {
         e.preventDefault();
         //$('#common-modal').modal('show');
       });
    });");
}


/*echo '<pre>';
print_r($current_data);
echo '</pre>';
echo $data['name'];*/
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success box-solid text-center">
            <div class="box-header">
                <h3 class="box-title"><?= $mesin_description; ?></h3>
            </div>
            <div class="box-body no-padding">
                <table class="table table-responsive table-stripped" style="font-size: 24px;">
                    <thead>
                        <tr class="">
                            <th class="text-center" style="vertical-align: middle;">Lot Number</th>
                            <th class="text-center" style="vertical-align: middle;">Qty</th>
                            <th class="text-center" style="vertical-align: middle;">GMC</th>
                            <th style="vertical-align: middle;">Description</th>
                            <th style="vertical-align: middle;">Man Power<?= ' (' . $output_data['man_power_qty'] . ')'; ?></th>
                            <th width="150" class="text-center" style="vertical-align: middle;">Start Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!isset($output_data['lot_number'])) {
                            $btn_end_class = 'btn btn-danger btn-block btn-lg disabled';
                            echo '<tr><td colspan=5 style="text-align: left;">Machine is idling ...</td></tr>';
                        } else {
                            $btn_end_class = 'showModalButton btn btn-danger btn-block btn-lg';
                            echo '<tr class="">
                                <td class="text-center" style="vertical-align: middle;">' . $output_data['lot_number'] . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $output_data['lot_qty'] . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $output_data['gmc'] . '</td>
                                <td style="text-align: left; vertical-align: middle;">' . $output_data['gmc_desc'] . '</td>
                                <td style="text-align: left; vertical-align: middle;">' . $output_data['man_power_name'] . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . date('Y-m-d H:i', strtotime($output_data['start_date'])) . '</td>
                            </tr>';
                        }
                        ?>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer text-right">
                <?= Html::a('FINISH', ['finish', 'mesin_id' => $mesin_id], [
                            'class' => $btn_end_class,
                            /*'data' => [
                                'confirm' => 'Are you sure to start lot number ' . $value['lot_id'] . ' ?',
                            ],*/
                        ]); /*Html::button('FINISH', [
                    'id' => 'btn-complete',
                    'class' => $btn_end_class,
                    'title' => 'Finish Machine Process',
                    'value' => !isset($current_data['lot_id']) ? '#' : Url::to(['finish', 'mesin_id' => $mesin_id]),
                ]);*/ ?>
            </div>
        </div>
    </div>
</div>
<div class="row"></div>

<table class="table table-responsive table-stripped table-bordered" id="progress-tbl">
    <thead>
        <tr>
            <th class="text-center">Action</th>
            <th class="text-center">Lot Number</th>
            <th class="text-center">Plan Date</th>
            <th class="text-center">Part Number</th>
            <th>Part Name</th>
            <th class="text-center">Lot Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!$lot_data) {
            echo '<tr>
                <td colspan=5 style="font-size: 20px;">There is no plan for this machine ...</td>
            </tr>';
        }
        foreach ($lot_data as $key => $value) {
            ?>
            <tr>
                <td class="text-center">
                    <?php
                    if ($value['plan_run'] == 'R') {
                        echo Html::button('RUNNING', [
                            'class' => 'btn btn-warning btn-block disabled'
                        ]);
                    } else {
                        if (!isset($output_data['lot_number'])) {
                            echo Html::a('START', ['start-machine', 'mesin_id' => $mesin_id, 'lot_id' => $value['lot_id']], [
                                'class' => 'btn btn-success btn-block',
                                'data' => [
                                    'confirm' => 'Are you sure to start lot number ' . $value['lot_id'] . ' ?',
                                ],
                            ]);
                        } else {
                            echo Html::button('<strike>START</strike>', [
                                'class' => 'btn btn-success btn-block disabled'
                            ]);
                        }
                    }
                    
                    ?>
                </td>
                <td class="text-center"><?= $value['lot_id']; ?></td>
                <td class="text-center"><?= date('Y-m-d', strtotime($value['plan_date'])); ?></td>
                <td class="text-center"><?= $value['child_all']; ?></td>
                <td><?= $value['child_desc_all']; ?></td>
                <td class="text-center"><?= (int)$value['qty_all']; ?></td>
            </tr>
        <?php }
        ?>
        
    </tbody>
</table>