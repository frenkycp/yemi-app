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
//$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data);
echo '</pre>';*/

?>

<?php
$height = 350;
echo '<div class="box box-solid">';
    echo '<div class="box-header with-border">';
        //echo '<h3 class="box-title">Bodomari Monitoring</h3>';
    echo '</div>';
    echo '<div class="box-body">';
        echo '<div class="box-group" id="accordion">';
        foreach ($data as $key => $value) {
            echo '<div class="panel box box-' . $value['panel_class'] . '">';
                echo '<div class="box-header with-border">';
                    echo '<h4 class="box-title">';
                        echo '<a data-toggle="collapse" data-parent="#accordion" href="#collapse' . $key .'">';
                            echo '<b>' . $key . '</b> - ' . $value['item_desc'];
                        echo '</a>';
                    echo '</h4>';
                echo '</div>';
                echo '<div id="collapse' . $key .'" class="panel-collapse collapse">';
                    echo '<div class="box-body">';
                        echo '<div class="nav-tabs-custom">';
                            echo '<ul class="nav nav-tabs">';
                                echo '<li class="active"><a href="#tab_1_' . $key . '" data-toggle="tab">Long</a></li>';
                                echo '<li><a href="#tab_2_' . $key .'" data-toggle="tab">Short</a></li>';
                            echo '</ul>';
                            echo '<div class="tab-content">';
                                echo '<div class="tab-pane active" id="tab_1_' . $key . '">';
                                    echo Highcharts::widget([
                                        'scripts' => [
                                            //'modules/exporting',
                                            //'themes/sand-signika',
                                        ],
                                        'options' => [
                                            'chart' => [
                                                'zoomType' => 'x',
                                                'height' => $height,
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
                                            'yAxis' => [
                                                'title' => [
                                                    'enabled' => true,
                                                    'text' => $value['uom'],
                                                ],
                                            ],
                                            'tooltip' => [
                                                'shared' => true,
                                                'crosshairs' => true,
                                                'xDateFormat' => '%Y-%m-%d',
                                                'valueSuffix' => ' ' . $value['uom'],
                                            ],
                                            'series' => [
                                                [
                                                    'name' => '(WH + WIP) Stock by MRP　（在庫量ーMRP）',
                                                    'data' => $value['data1'],
                                                    'color' => new JsExpression('Highcharts.getOptions().colors[4]'),
                                                ],
                                                [
                                                    'name' => '(WH + WIP) Stock by Actual  （在庫量ー現実）',
                                                    'data' => $value['data2'],
                                                    'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
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
                                            //'modules/exporting',
                                            //'themes/sand-signika',
                                        ],
                                        'options' => [
                                            'chart' => [
                                                'height' => $height,
                                                'zoomType' => 'x',
                                            ],
                                            'title' => [
                                                'text' => null,
                                            ],
                                            'legend' => [
                                                //'enabled' => false
                                            ],
                                            'credits' => [
                                                'enabled' => false
                                            ],
                                            'xAxis' => [
                                                'type' => 'datetime',
                                                //'categories' => $value['categories']
                                            ],
                                            'tooltip' => [
                                                'valueSuffix' => '%',
                                            ],
                                            'yAxis' => [
                                                'title' => [
                                                    'enabled' => true,
                                                    'text' => 'Percentage',
                                                ],
                                                'plotLines' => [[
                                                    'value' => 0,
                                                    'color' =>  '#FF0000',
                                                    'width' => 2,
                                                    'zIndex' => 0,
                                                    'label' => ['text' => 'goal']
                                                ]]
                                            ],
                                            'series' => [
                                                [
                                                    'name' => 'DEVIASI',
                                                    'data' => $value['deviasi'],
                                                ],
                                            ],
                                        ],
                                    ]);
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    echo '</div>';
echo '</div>';
/*
foreach ($data as $key => $value) {
    echo '<div class="panel panel-primary">';
        echo '<div class="panel panel-heading">';
            echo $key;
        echo '</div>';
        echo '<div class="panel panel-body">';
            
        echo '</div>';
    echo '</div>';
}*/
?>