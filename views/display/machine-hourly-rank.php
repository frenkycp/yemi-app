<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    //'page_title' => 'Machine Utility Rank (Daily) <span class="japanesse text-green"></span>',
    'page_title' => null,
    'tab_title' => 'Machine Utility Rank (Last Hour)',
    'breadcrumbs_title' => 'Machine Utility Rank (Last Hour)'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
");

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title" style="font-size: 28px;">Machine Utility [ <?= date('Y-m-d H:00', strtotime($last_hour)) ?> ]</h3>
    </div>
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                'themes/dark-unica',
                //'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    //'zoomType' => 'x'
                    'height' => 500
                ],
                'title' => [
                    'text' => 'Machine Utility (Last Hour)'
                ],
                'subtitle' => [
                    'text' => ''
                ],
                'xAxis' => [
                    'categories' => $categories,
                ],
                'yAxis' => [
                    //'min' => 0,
                    'title' => [
                        'text' => 'Percentage'
                    ],
                    'max' => 100,
                    //'gridLineWidth' => 0,
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    //'xDateFormat' => '%A, %b %e %Y',
                    'valueSuffix' => '%'
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'column' => [
                        //'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                            'format' => '{point.y}%',
                            'style' => [
                                //'color' => 'white',
                                'fontWeight' => 'bold',
                                'fontSize' => '20px',
                            ],
                        ],
                    ],
                    'series' => [
                        'pointPadding' => 0.1,
                        'groupPadding' => 0,
                        /*'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ],
                        'maxPointWidth' => 50*/
                    ]
                ],
                'series' => $data,
            ],
        ]);
        ?>
    </div>
</div>
<div class="col-md-3" style="border: 1px solid white;">
    <table class="table" style="color: white; text-align: center; font-size: 20px;">
        <tr>
            <td rowspan="2" style="vertical-align: middle; text-align: right; border-top: 0px;">
                Machine Utility
            </td>
            <td rowspan="2" style="vertical-align: middle; border-top: 0px;"> = </td>
            <td style="border-top: 0px;">
                Green
            </td>
        </tr>
        <tr>
            <td>
                Green + Blue + Yellow
            </td>
        </tr>
    </table>
</div>