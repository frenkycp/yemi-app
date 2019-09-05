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

date_default_timezone_set('Asia/Jakarta');

$this->title = [
    'page_title' => 'Temperature & Humidity Monitoring <small style="color: white; opacity: 0.8;" id="last-update"> Last Update : ' . date('Y-m-d H:i:s') . '</small><span class="japanesse text-green"></span>',
    'tab_title' => 'Temperature & Humidity Monitoring',
    'breadcrumbs_title' => 'Temperature & Humidity Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; color: white;}
    body, .content-wrapper {background-color: #000;}
    .box-no {background-color: green; width:20px;}
    table tr td, table tr th {border: 1px solid #d2d2d2; border-radius: 5px;}
    .factory-container {border: 1px solid white; border-radius: 5px;}
");



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

/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div class="row">
    <div class="col-md-6">
        <div style="color: white; font-size: 2em;"><span>FACTORY 1</span></div>
        <div class="factory-container">
            <div class="row">
                <?php
                foreach ($factory1_data as $key => $value) {
                    ?>
                    <div class="col-md-4">
                        <div class="panel panel-primary" style="margin: 15px;">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title">
                                    <?= Html::a($value->area, ['temp-humidity-chart', 'map_no' => $value->map_no], ['target' => '_blank']); ?>
                                </h3>
                            </div>
                            <div class="panel-body no-padding">
                                <table class="table" style="margin-bottom: 0px;">
                                    <tr>
                                        <th class="text-center" width="50%">Temperature</th>
                                        <th class="text-center" width="50%">Humidity</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 1.5em; font-weight: bold;"><?= $value->temparature == null ? '-' : $value->temparature . '&deg;C'; ?></td>
                                        <td class="text-center" style="font-size: 1.5em; font-weight: bold;"><?= $value->humidity == null ? '-' : $value->humidity . '&#37;'; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div style="color: white; font-size: 2em;"><span>FACTORY 2</span></div>
        <div class="factory-container">
            <div class="row">
                <?php
                foreach ($factory2_data as $key => $value) {
                    ?>
                    <div class="col-md-4">
                        <div class="panel panel-primary" style="margin: 15px;">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title">
                                    <?= Html::a($value->area, ['temp-humidity-chart', 'map_no' => $value->map_no], ['target' => '_blank']); ?>
                                </h3>
                            </div>
                            <div class="panel-body no-padding">
                                <table class="table" style="margin-bottom: 0px;">
                                    <tr>
                                        <th class="text-center" width="50%">Temperature</th>
                                        <th class="text-center" width="50%">Humidity</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="font-size: 1.5em; font-weight: bold;"><?= $value->temparature == null ? '-' : $value->temparature . '&deg;C'; ?></td>
                                        <td class="text-center" style="font-size: 1.5em; font-weight: bold;"><?= $value->humidity == null ? '-' : $value->humidity . '&#37;'; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>
<div id="main-body">
    <?= ''; //Html::img('@web/uploads/MAP/suhu_humidity_map.JPG', ['alt' => 'My logo', 'style' => 'opacity: 0.8']); ?>
</div>