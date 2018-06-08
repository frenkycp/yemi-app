<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Finish Goods Stock (完成品在庫) : ' . $grand_total);
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
    <div class="box-body no-padding">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                //'themes/grid-light',
                'themes/sand-signika',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'bar',
                    'height' => 500
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
                    'enabled' => false
                ],
                'xAxis' => [
                    'categories' => $categories
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Qty',
                        'align' => 'high'
                    ],
                    'labels' => [
                        'overflow' => 'justify'
                    ]
                ],
                'plotOptions' => [
                    'bar' => [
                        'dataLabels' => [
                            'enabled' => true
                        ]
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('
                                    function(){
                                        $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                    }
                                '),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ]
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Shipping Stock',
                        'data' => $data,
                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
                    ]
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
    </div>
</div>