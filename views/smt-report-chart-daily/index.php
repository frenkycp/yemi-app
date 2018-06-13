<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'SMT Report Daily');
$this->params['breadcrumbs'][] = $this->title;
$color = 'ForestGreen';

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

?>
<?php 
/*echo '<pre>';
print_r($loc);
echo '</pre>';

echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php
        $i = 1;
        foreach ($data as $key => $value) {
            if($i == 1)
            {
                echo '<li class="active"><a href="#tab_1_' . $i . '" data-toggle="tab">Line ' . $key . '</a></li>';
            }
            else
            {
                echo '<li><a href="#tab_1_' . $i . '" data-toggle="tab">Line ' . $key . '</a></li>';
            }
            $i++;
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php
        $j = 1;
        foreach ($data as $key => $value) {
            if($j == 1)
            {
                echo '<div class="tab-pane active" id="tab_1_' . $j .'">';
            }
            else
            {
                echo '<div class="tab-pane" id="tab_1_' . $j .'">';
            }
            
            echo Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/sand-signika',
                    //'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        //'type' => 'spline'
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'title' => [
                        'text' => 'SMT Report'
                    ],
                    'xAxis' => [
                        'categories' => $value['category']
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Presentase (%)'
                        ]
                    ],
                    'plotOptions' => [
                        'line' => [
                            'dataLabels' => [
                                'enabled' => true,
                                'style' => [
                                    'textOutline' => '0px'
                                ],
                                'allowOverlap' => true
                            ],
                            //'enableMouseTracking' => false
                        ]
                    ],
                    'series' => [
                        ['name' => 'Utilization', 'data' => $value['utilization']],
                        ['name' => 'Eficiency', 'data' => $value['eficiency']]
                    ]
                ],
            ]);
            echo '</div>';
            $j++;
        }
        for($j = 1; $j <= 2; $j++)
        {
            
        }
        ?>
    </div>
</div>