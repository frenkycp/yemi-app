<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'MONTHLY SHIPPING CONTAINER <span class="japanesse text-green">(月次コンテナー出荷)</span>',
    'tab_title' => 'MONTHLY SHIPPING CONTAINER',
    'breadcrumbs_title' => 'MONTHLY SHIPPING CONTAINER'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");
$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}

    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
");

date_default_timezone_set('Asia/Jakarta');

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

/*echo '<pre>';
print_r($data2);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<h2  style="color: white;">Last Update : <?= date('Y-m-d H:i'); ?></h2>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> Total Container <span class="japanesse">(コンテナー総本数）</span> : <?= $total_container; ?></h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">
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
                    'style' => [
                        'fontFamily' => 'Source Sans Pro'
                    ],
                    'height' => 700
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => date('Y, F'),
                    'style' => [
                    	'fontSize' => '20px'
                    ]
                ],
                'subtitle' => [
                    'text' => null
                ],
                'xAxis' => [
                    'type' => 'category',
                    'categories' => $category,
                    'title' => [
                        'text' => 'Date'
                    ],
                    'labels' => [
                        'formatter' => new JsExpression('function(){ return \'<a href="' . Yii::$app->request->baseUrl . '/serno-output/container-progress?etd=\' + this.value + \'">\' + this.value + \'</a>\'; }'),
                        'style' => [
                        	'fontSize' => '14px'
                        ],
                    ],
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Container Completion'
                    ],
                    'stackLabels' => [
                        //'enabled' => true,
                        //'formatter' => new JsExpression('function(){ return this.qty + "aa"; }'),
                    ]
                ],
                'tooltip' => [
                    'enabled' => false
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                            'style' => [
                                'textOutline' => '0px',
                                'fontWeight' => '0',
                                'fontSize' => '16px'
                            ],
                            'format' => '{point.qty}/{point.total_qty}',
                            'color' => 'black',
                        ],
                    ],
                    /*'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('
                                    function(){
                                        $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                    }
                                '),
                            ]
                        ]
                    ]*/
                ],
                'series' => $data
            ],
        ]);
        ?>
        </div>
    </div>
</div>