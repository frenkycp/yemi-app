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
    'tab_title' => 'Machine Utility Rank (Last Day)',
    'breadcrumbs_title' => 'Machine Utility Rank (Last Day)'
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
print_r($shipping_data);
echo '</pre>';*/

?>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">SHIPPING SUMMARY</h3>
            </div>
            <div class="panel-body no-padding">
                <table class="table table-responsive table-bordered table-striped text-center" style="font-size: 1.2em;">
                    <thead>
                        <tr>
                            <th>Shipping Date</th>
                            <th>Plan</th>
                            <th>Actual</th>
                            <th>Balance</th>
                            <th>Percentage</th>
                            <th>Outstanding Model (Top 3)</th>
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
                                        //echo '<ul class="text-left">';
                                        foreach ($value['gmc_balance'] as $gmc_number => $balance) {
                                            echo '<div class="well well-sm" style="text-align: left;">';
                                            //echo $model_name[$gmc_number];
                                            echo $gmc_number;
                                            echo '<span class="text-red pull-right"> (' . $balance . ')</span>';
                                            echo '</div>';
                                        }
                                        //echo '</ul>';
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
    <div class="col-md-6"></div>
</div>
