<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'Production Budget/Forecast/Actual',
    'tab_title' => 'Production Budget/Forecast/Actual',
    'breadcrumbs_title' => 'Production Budget/Forecast/Actual'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($series);
echo '</pre>';*/

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">FISCAL YEAR <?= $fiscal; ?> (By Amount)</h3>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/grid-light',
                //'themes/sand-signika',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 450
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => $title
                ],
                'subtitle' => [
                    'text' => $subtitle
                ],
                'xAxis' => [
                    'categories' => $categories
                ],
                'yAxis' => [
                    'allowDecimals' => false,
                    'min' => 0,
                    //'max' => 160000,
                    'tickInterval' => 1000000,
                    'title' => [
                        'text' => 'AMOUNT'
                    ]
                ],
                'legend' => [
                    'enabled' => false,
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal'
                    ]
                ],
                'series' => $series
            ],
        ]);
        ?>
    </div>
</div>