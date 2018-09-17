<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Monthly Monitoring Uncountable Parts <span class="japanesse text-green">(不定材の受払い管理) ― 準備中</span>',
    'tab_title' => 'Monthly Monitoring Uncountable Parts',
    'breadcrumbs_title' => 'Monthly Monitoring Uncountable Parts'
];

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
print_r($data);
echo '</pre>';*/

?>

<?php
foreach ($data as $key => $value) {
    echo '<div class="panel panel-primary">';
    echo '<div class="panel panel-heading">';
    echo $key;
    echo '</div>';
    echo '<div class="panel panel-body">';
    echo Highcharts::widget([
        'scripts' => [
            'modules/exporting',
            'themes/grid-light',
        ],
        'options' => [
            'chart' => [
                'type' => 'spline',
                'height' => 300,
            ],
            'xAxis' => [
                'type' => 'category',
                'categories' => $value['categories']
            ],
            'plotOptions' => [
                'spline' => [
                    'marker' => [
                        //'radius' => 4,
                        'lineColor' => '#666666',
                        'lineWidth' => 1
                    ]
                ]
            ],
            'series' => [
                [
                    'name' => 'ENDING QTY',
                    'data' => $value['data1']
                ],
                [
                    'name' => 'WH ENDING QTY',
                    'data' => $value['data2']
                ]
            ],
        ],
    ]);
    echo '</div>';
    echo '</div>';
}
?>