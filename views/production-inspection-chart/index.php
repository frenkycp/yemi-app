<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    'page_title' => 'Production Inspection Chart <span>(週次出荷管理検査)</span>',
    'tab_title' => 'Weekly Final Inspection chart (週次出荷管理検査)',
    'breadcrumbs_title' => 'Weekly Final Inspection chart (週次出荷管理検査)'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
//$color = 'DarkSlateBlue';
$color = 'rgba(72,61,139,0.6)';

$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$this->registerCss(".tab-content > .tab-pane,
.pill-content > .pill-pane {
    display: block;     
    height: 0;          
    overflow-y: hidden; 
}

.tab-content > .active,
.pill-content > .active {
    height: auto;       
} ");

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

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php
        foreach ($data as $key => $value) {
            if($key == $weekToday)
            {
                echo '<li class="active"><a href="#tab_1_' . $key . '" data-toggle="tab">Week ' . $key . '</a></li>';
            }
            else
            {
                echo '<li><a href="#tab_1_' . $key . '" data-toggle="tab">Week ' . $key . '</a></li>';
            }
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php
        foreach ($data as $key => $value) {
            if($key == $weekToday)
            {
                echo '<div class="tab-pane active" id="tab_1_' . $key .'">';
            }
            else
            {
                echo '<div class="tab-pane" id="tab_1_' . $key .'">';
            }
            $sernoFg = $data[$key];
            $category = $sernoFg['category'];
            $data_series = $sernoFg['data'];

            $tmp_period = [];

            /*echo '<pre>';
            print_r($data_series);
            echo '</pre>';*/

            echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 400,
                    'width' => null
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => null
                ],
                'subtitle' => [
                    'text' => null
                ],
                'xAxis' => [
                    'type' => 'category'
                ],
                'xAxis' => [
                    'categories' => $category,
                    'labels' => [
                        'formatter' => new JsExpression('function(){ return \'<a href="container-progress?etd=\' + this.value + \'">\' + this.value + \'</a>\'; }'),
                    ],
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Total Completion (%)'
                    ],
                    'gridLineWidth' => 0,
                ],
                'tooltip' => [
                    'enabled' => true,
                    /*'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + this.point.qty + " lot"; }'),*/
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                            'style' => [
                                'fontSize' => '14px',
                                'fontWeight' => '0'
                            ],
                        ],
                        //'borderWidth' => 1,
                        //'borderColor' => $color,
                    ],
                    'series' => [
                        
                    ]
                ],
                'series' => $data_series
            ],
        ]);
            echo '</div>';
        }
        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            //'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>
</div>