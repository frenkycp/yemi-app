<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    //'page_title' => 'Machine Utility Rank (Daily) <span class="japanesse text-green"></span>',
    'page_title' => null,
    'tab_title' => 'Morning Chourei',
    'breadcrumbs_title' => 'Morning Chourei'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    //body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
");

//$this->registerCssFile('@web/adminty_assets/css/bootstrap.min.css');
//$this->registerCssFile('@web/adminty_assets/css/component.css');
//$this->registerCssFile('@web/adminty_assets/css/style.css');
/*echo '<pre>';
print_r($vms_data);
echo '</pre>';*/

?>
<div class="row">
    <?php
    foreach ($cal_arr as $key => $value) {
        $tmp_shipping_data = $shipping_data[$value];
        ?>
        <div class="col-md-4">
            <div class="text-center">
                <span style="color: white; font-size: 20px;"><?= $value; ?></span>
            </div>
            
            <hr/>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">SHIPPING SUMMARY</h3>
                </div>
                <div class="panel-body no-padding">
                    <table class="table table-responsive table-bordered table-striped text-center" style="font-size: 1.5em;">
                        <thead>
                            <tr>
                                <!--<th style="vertical-align: middle;">Shipping Date</th>-->
                                <th style="vertical-align: middle;">Plan</th>
                                <th style="vertical-align: middle;">Actual</th>
                                <th style="vertical-align: middle;">Min.</th>
                                <th style="vertical-align: middle;">Outstanding Model<br/>(Top 3)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!--<td style="vertical-align: middle;"><?= ''; //date('j M\' Y', strtotime($value)); ?></td>-->
                                <td style="vertical-align: middle;"><?= number_format($tmp_shipping_data['plan']); ?></td>
                                <td style="vertical-align: middle;"><?= number_format($tmp_shipping_data['actual']); ?></td>
                                <td style="vertical-align: middle;"><?= number_format($tmp_shipping_data['balance']) . '<br/><span class="text-red">(' . (100 - $tmp_shipping_data['percentage']) . '%)</span>'; ?></td>
                                <td style="vertical-align: middle;">
                                    <?php
                                    if (isset($tmp_shipping_data['gmc_balance'])) {
                                        echo '<ul class="text-left">';
                                        foreach ($tmp_shipping_data['gmc_balance'] as $gmc_number => $balance) {
                                            echo '<li>';
                                            echo $gmc_number;
                                            echo ' <i class="fa fa-fw fa-long-arrow-right"></i> <span class="text-red"> [' . number_format($balance) . ']</span>';
                                            echo '</li>';
                                        }
                                        echo '</ul>';
                                    } else {
                                        echo "-";
                                    }
                                    
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            

        </div>
    <?php }
    ?>
</div>
<div class="row">
    <?php
    foreach ($cal_arr as $key => $value) {
        ?>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">WIP COMPLETION DUE TO VMS DATE</h3>
                </div>
                <div class="panel-body no-padding">
                    <table class="table table-responsive table-bordered table-striped text-center" style="font-size: 1.3em;">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;">Location</th>
                                <th style="vertical-align: middle;">Plan</th>
                                <th style="vertical-align: middle;">Actual</th>
                                <th style="vertical-align: middle;">Min.</th>
                                <th style="vertical-align: middle;">Outstanding Model<br/>(Top 3)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($vms_data as $child_analyst_desc => $vms_detail) {
                                ?>
                                <tr>
                                    <td style="vertical-align: middle;"><?= $child_analyst_desc; ?></td>
                                    <td style="vertical-align: middle;"><?= number_format($vms_detail[$value]['plan']); ?></td>
                                    <td style="vertical-align: middle;"><?= number_format($vms_detail[$value]['actual']); ?></td>
                                    <td style="vertical-align: middle;"><?= number_format($vms_detail[$value]['balance']) . '<br/><span class="text-red">(' . (100 - (float)$vms_detail[$value]['percentage']) . '%)</span>'; ?></td>
                                    <td style="vertical-align: middle;">
                                        <?php
                                        if (isset($vms_detail[$value]['gmc_balance'])) {
                                            echo '<ul class="text-left">';
                                            foreach ($vms_detail[$value]['gmc_balance'] as $gmc_number => $balance) {
                                                echo '<li>';
                                                echo $gmc_number;
                                                echo ' <i class="fa fa-fw fa-long-arrow-right"></i> <span class="text-red"> [' . number_format($balance) . ']</span>';
                                                echo '</li>';
                                            }
                                            echo '</ul>';
                                        } else {
                                            echo "-";
                                        }
                                        
                                        ?>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php }
    ?>
</div>
<hr/>
<div style="display: none;" class="row">
    <div class="col-md-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">INSPECTION SUMMARY</h3>
            </div>
        </div>
    </div>
</div>
<div class="row" style="display: none;">
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">SHIPPING SUMMARY</h3>
            </div>
            <div class="panel-body no-padding">
                <table class="table table-responsive table-bordered table-striped text-center" style="font-size: 1.2em;">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle;">Shipping Date</th>
                            <th style="vertical-align: middle;">Plan</th>
                            <th style="vertical-align: middle;">Actual</th>
                            <th style="vertical-align: middle;">Min.</th>
                            <th style="vertical-align: middle;">Percentage</th>
                            <th style="vertical-align: middle;">Outstanding Model<br/>(Top 3)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($shipping_data as $key => $value) {
                            ?>
                            <tr>
                                <td style="vertical-align: middle;"><?= date('j M\' Y', strtotime($key)); ?></td>
                                <td style="vertical-align: middle;"><?= number_format($value['plan']); ?></td>
                                <td style="vertical-align: middle;"><?= number_format($value['actual']); ?></td>
                                <td style="vertical-align: middle;"><?= number_format($value['balance']); ?></td>
                                <td style="vertical-align: middle;"><?= $value['percentage'] . '%'; ?></td>
                                <td style="vertical-align: middle;">
                                    <?php
                                    if (isset($value['gmc_balance'])) {
                                        echo '<ul class="text-left">';
                                        foreach ($value['gmc_balance'] as $gmc_number => $balance) {
                                            echo '<li>';
                                            echo $gmc_number;
                                            echo ' <i class="fa fa-fw fa-long-arrow-right"></i> <span class="text-red"> [' . $balance . ']</span>';
                                            echo '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                    
                                    ?>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            
        </div>
    </div>
</div>
