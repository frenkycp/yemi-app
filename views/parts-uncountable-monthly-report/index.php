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
      setTimeout("refreshPage();", 18000000); // milliseconds
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
            echo '<div class="nav-tabs-custom">';
                echo '<ul class="nav nav-tabs">';
                    echo '<li class="active"><a href="#tab_1_' . $key . '" data-toggle="tab">Long</a></li>';
                    echo '<li><a href="#tab_2_' . $key .'" data-toggle="tab">Short</a></li>';
                echo '</ul>';
                echo '<div class="tab-content">';
                    echo '<div class="tab-pane active" id="tab_1_' . $key . '">';
                        echo Highcharts::widget([
                            'scripts' => [
                                'modules/exporting',
                                'themes/grid-light',
                            ],
                            'options' => [
                                'chart' => [
                                    //'zoomType' => 'x',
                                    'height' => 400,
                                ],
                                'title' => [
                                    'text' => null,
                                ],
                                'credits' => [
                                    'enabled' => false
                                ],
                                'xAxis' => [
                                    'type' => 'datetime',
                                    //'categories' => $value['categories']
                                ],
                                'tooltip' => [
                                    'shared' => true,
                                    'crosshairs' => true,
                                    'xDateFormat' => '%Y-%m-%d'
                                ],
                                'series' => [
                                    [
                                        'name' => 'WH Stock by BOM　（在庫量ーBOM）',
                                        'data' => $value['data1'],
                                    ],
                                    [
                                        'name' => 'WH Stock by Actual  （在庫量ー現実）',
                                        'data' => $value['data2'],
                                    ],
                                    /*[
                                        'name' => 'DEVIASI',
                                        'data' => $value['deviasi']
                                    ],*/
                                ],
                            ],
                        ]);
                    echo '</div>';
                    echo '<div class="tab-pane" id="tab_2_' . $key .'">';
                        echo Highcharts::widget([
                            'scripts' => [
                                'modules/exporting',
                                'themes/grid-light',
                            ],
                            'options' => [
                                'chart' => [
                                    'height' => 400,
                                    'type' => 'column'
                                ],
                                'title' => [
                                    'text' => null,
                                ],
                                'legend' => [
                                    'enabled' => false
                                ],
                                'credits' => [
                                    'enabled' => false
                                ],
                                'xAxis' => [
                                    'type' => 'datetime',
                                    //'categories' => $value['categories']
                                ],
                                'yAxis' => [
                                    'title' => 'Percentage'
                                ],
                                'series' => [
                                    [
                                        'name' => 'DEVIASI',
                                        'data' => $value['deviasi']
                                    ],
                                ],
                            ],
                        ]);
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
}
?>