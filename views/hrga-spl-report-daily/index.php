<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'SPL Report');
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
/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Chart View</h3>
    </div>
    <div class="box-body no-padding">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                //'themes/grid-light',
                'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 500,
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
                    'categories' => $category
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Total fruit consumption'
                    ],
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            'fontWeight' => 'bold',
                            //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        ]
                    ]
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                            'style' => [
                                'textOutline' => '0px',
                                'fontWeight' => '0'
                            ],
                        ]
                    ]
                ],
                'series' => $data
            ],
        ]);
        ?>
    </div>
</div>