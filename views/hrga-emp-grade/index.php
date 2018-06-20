<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Grade Structure');
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
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

?>
<?php
//echo '<pre>';
//print_r($data);
//echo '</pre>';
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><?= date('d-M-Y') ?></h3>
    </div>
    <div class="box-body no-padding">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                //'themes/grid-light',
                //'themes/sand-signika',
                'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'bar',
                    'height' => 550,
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => $title
                ],
                'subtitle' => [
                    'text' => $subtitle
                ],
                'xAxis' => [
                    [
                        'crosshair' => true,
                        'categories' => $categories,
                        'reversed' => false,
                        'labels' => [
                            'step' => 1
                        ]
                    ],
                    [ // mirror axis on right side
                        'crosshair' => true,
                        'opposite' => true,
                        'reversed' => false,
                        'categories' => $categories,
                        'linkedTo' => 0,
                        'labels' => [
                            'step' => 1
                        ]
                    ]
                    
                ],
                'yAxis' => [
                    [
                        'title' => [
                            'text' => null
                        ],
                        'labels' => [
                            'formatter' => new JsExpression("function () { return Math.abs(this.value) + '' }")
                        ],
                        'max' => 450,
                    ],
                    [
                        'title' => [
                            'text' => null
                        ],
                        'labels' => [
                            'formatter' => new JsExpression("function () { return Math.abs(this.value) + '' }")
                        ],
                        'max' => 450,
                    ]
                ],
                'tooltip' => [
                    'formatter' => new JsExpression("function () {
                        return '<b>' + this.series.name + ', Grade ' + this.point.category + '</b><br/>' +
                            'Total: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0);
                    }")
                ],
                'plotOptions' => [
                    'series' => [
                        'stacking' => 'normal',
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ]
                    ]
                ],
                'series' => $data,
            ],
        ]);
        ?>
    </div>
</div>