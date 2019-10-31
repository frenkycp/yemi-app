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
    'page_title' => 'Machine Utility',
    'tab_title' => 'Machine Utility',
    'breadcrumbs_title' => 'Machine Utility'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($series);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<div class="box box-primary box-solid">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => 'Machine Utility',
                    ],
                    'xAxis' => [
                        'type' => 'category',
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Percentage',
                        ]
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'valueSuffix' => ' minutes'
                    ],
                    'legend' => [
                        'enabled' => false
                    ],
                    'plotOptions' => [
                        'series' => [
                            'borderWidth' => 0,
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.y:.1f}%'
                            ],
                        ],
                    ],
                    'series' => $series,
                ],
            ]);
            ?>
        </div>
    </div>
</div>