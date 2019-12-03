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
    'page_title' => 'FINISH GOOD STOCK (<span class="japanesse light-green">完成品在庫</span>) : <b>' . number_format($grand_total) . '</b> pcs (' . round($grand_total_kubikasi, 2) . ' m<sup>3</sup> &efDot; ' . $total_kontainer . ' containers &efDot; ' . $day_total . ')',
    'tab_title' => 'FINISH GOOD STOCK',
    'breadcrumbs_title' => 'FINISH GOOD STOCK'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("");

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 2.8em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 60000); // milliseconds
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
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?= 'Update Stock ' . date('d M\' Y H:i') ?></h3>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
                //'themes/sand-signika',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 600,
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
                    'enabled' => true,
                    'itemStyle' => [
                        'fontSize' => '18px',
                    ],
                ],
                'xAxis' => [
                    'categories' => $categories,
                    'labels' => [
                        'style' => [
                            'fontSize' => '20px',
                            'fontWeight' => 'bold'
                        ],
                    ],
                ],
                'yAxis' => [
                    'min' => 0,
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            //'color' => 'white',
                            'fontWeight' => 'bold',
                            'fontSize' => '20px',
                        ],
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
                        'name' => 'FA - Under Inspection',
                        'data' => $data[2],
                        'color' => 'rgba(255, 150, 0, 1)',
                    ],
                    [
                        'name' => 'FA - OK',
                        'data' => $data[3],
                        'color' => 'rgba(0, 255, 0, 1)',
                    ],
                    [
                        'name' => 'Finish Good WH - Under Inspection',
                        'data' => $data[0],
                        'color' => 'rgba(0, 200, 255, 1)',
                    ],
                    [
                        'name' => 'Finish Good WH - OK',
                        'data' => $data[1],
                        'color' => 'rgba(0, 0, 255, 1)',
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
            <span class="text-light-blue" style="font-size: 30px;"><b> 1 container &efDot; 54 m<sup>3</sup></b></span>
            <br/>
            <span class="text-light-blue" style="font-size: 30px;"><b> 1 day output &efDot; 5,000 pcs</b></span>
        </div>
    </div>
    
</div>
    </div>
</div>