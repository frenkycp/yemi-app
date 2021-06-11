<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$day_stock = round($grand_total / 5000);
if($day_stock > 1){
    $day_total = $day_stock . ' days stock';
} else {
    $day_total = $day_stock . ' day stock';
}

$this->title = [
    'page_title' => 'Finish Goods Stock <span class="light-green japanesse">(完成品在庫)</span> : <b>' . number_format($grand_total) . '</b> pcs (' . $day_total . ')',
    'tab_title' => 'Finish Goods Stock',
    'breadcrumbs_title' => 'Finish Goods Stock'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("");

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
print_r($categories);
echo '</pre>';
echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= 'Update Stock ' . date('d M\' Y H:i:s') ?></h3>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
               // 'themes/sand-signika',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 500,
                    'style' => [
                        'fontFamily' => 'Source Sans Pro'
                    ],
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
                'legend' => [
                    'enabled' => true
                ],
                'xAxis' => [
                    'categories' => $categories
                ],
                'yAxis' => [
                    'min' => 0,
                    
                    'stackLabels' => [
                        'enabled' => true
                    ],
                ],
                'plotOptions' => [
                    /*'bar' => [
                        'dataLabels' => [
                            'enabled' => false,
                            'format' => '{point.y} pcs ({point.total_kubikasi} m3)'
                        ]
                    ],*/
                    'column' => [
                        'stacking' => 'normal',
                    ],
                    'series' => [
                        /*'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]*/
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Finish Good Stock',
                        'data' => $data[0],
                        'color' => 'rgba(0, 200, 255, 1)',
                    ],
                    
                    
                    
                    /*[
                        'name' => 'Production Floor (生産職場)',
                        'data' => $data[0],
                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
                    ],*/
                ]
            ],
        ]);

        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            //'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
        <div class="well well-sm">
            <h4 class="text-light-blue" style="display: none;"><b> 1 container &efDot; 54 m<sup>3</sup></b></h4>
            <h4 class="text-light-blue"><b> 1 day output &efDot; 5,000 pcs</b></h4>
        </div>
    </div>
    
</div>