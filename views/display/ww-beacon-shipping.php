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
    'page_title' => 'Beacon Detail Info <span class="japanesse text-green"></span>',
    'tab_title' => 'Beacon Detail Info',
    'breadcrumbs_title' => 'Beacon Detail Info'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
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
");

date_default_timezone_set('Asia/Jakarta');
?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-body">
                <dl>
                    <dt>Beacon ID : </dt>
                    <dd><?= $beacon_data->minor; ?></dd>
                    <dt>Lot Number : </dt>
                    <dd><?= $beacon_data->lot_number; ?></dd>
                    <dt>Start Time (First Process) : </dt>
                    <dd><?= $start_time; ?></dd>
                    <dt>Model : </dt>
                    <dd><?= $beacon_data->model_group; ?></dd>
                    <dt>Part Number : </dt>
                    <dd><?= $beacon_data->gmc; ?></dd>
                    <dt>Part Name : </dt>
                    <dd><?= $beacon_data->gmc_desc; ?></dd>
                    <dt>Qty : </dt>
                    <dd><?= $beacon_data->lot_qty; ?></dd>
                    <dt>Machine ID : </dt>
                    <dd><?= $beacon_data->mesin_id; ?></dd>
                    <dt>Machine Desc. : </dt>
                    <dd><?= $beacon_data->mesin_description; ?></dd>
                    <dt>Slip Number (<?= $slip_no_qty; ?>) : </dt>
                    <dd><?= $slip_no_txt; ?></dd>
                    <dt>HDR ID :</dt>
                    <dd><?= $tmp_hdr_dtr_txt; ?></dd>
                </dl>
                <hr>
                <dl>
                    <dt>Nearest Shipping Date :</dt>
                    <dd><?= $nearest_shipping_date; ?></dd>
                    <dt>Nearest FA Date :</dt>
                    <dd><?= $nearest_fa_date; ?></dd>
                    <dt>Lead Time to Shipping :</dt>
                    <dd><?= $lt_to_shipping; ?></dd>
                    <dt>Lead Time to FA Start :</dt>
                    <dd><?= $lt_to_fa; ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Shipping Information</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ETD</th>
                                    <th>Port</th>
                                    <th class="text-center">Container No.</th>
                                    <th class="text-center">GMC</th>
                                    <th class="text-center">Model</th>
                                    <th class="text-center">Plan Qty</th>
                                    <th class="text-center">Actual Qty</th>
                                    <th class="text-center">Balance Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_qty = $total_output = $total_balance = 0;
                                if (count($serno_output_data) > 0) {
                                    foreach ($serno_output_data as $key => $value) {
                                        $balance = $value->output - $value->qty;
                                        $total_qty += $value->qty;
                                        $total_output += $value->output;
                                        $total_balance += $balance;
                                        $data .= '<tr>
                                            <td class="text-center">' . $value->etd . '</td>
                                            <td>' . $value->dst . '</td>
                                            <td class="text-center">' . $value->cntr . '</td>
                                            <td class="text-center">' . $value->gmc . '</td>
                                            <td class="text-center">' . $value->partName . '</td>
                                            <td class="text-center">' . $value->qty . '</td>
                                            <td class="text-center">' . $value->output . '</td>
                                            <td class="text-center">' . $balance . '</td>
                                        </tr>';
                                    }
                                } else {
                                    $data .= '<tr>
                                        <td colspan="8">No shipping data connection ...</td>
                                    </tr>';
                                }
                                $data .= '</tbody>
                                    <tfoot>
                                        <tr class="info" style="font-weight: bold;">
                                            <td colspan="5">Total</td>
                                            <td class="text-center">' . $total_qty . '</td>
                                            <td class="text-center">' . $total_output . '</td>
                                            <td class="text-center">' . $total_balance . '</td>
                                        </tr>
                                    </tfoot>
                                </table>';
                                echo $data;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>