<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'FG Stocks Waiting time before Shipping (<span class="japanesse light-green">出荷までの完成品停滞時間</span>)<span style="font-size: 0.7em;"> Last Update : ' . date('Y-m-d H:i') . '</span>',
    'tab_title' => 'FG Stocks Waiting time before Shipping',
    'breadcrumbs_title' => 'FG Stocks Waiting time before Shipping'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 2.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}

    #progress-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #progress-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #595F66;
        color: white;
        font-size: 20px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #progress-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 16px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: top;
    }
");

date_default_timezone_set('Asia/Jakarta');

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

/*echo '<pre>';
print_r($tmp_data3);
echo '</pre>';*/

?>
<span style="color: white; font-size: 2em;">Total Stock : <?= number_format($grandtotal_stock); ?> pcs</span>
<div class="row">
    <div class="col-md-12">
        <?php
echo Highcharts::widget([
    'scripts' => [
        //'modules/exporting',
        //'themes/sand-signika',
        //'themes/grid-light',
        'themes/dark-unica',
    ],
    'options' => [
        'chart' => [
            'type' => 'column',
            'style' => [
                'fontFamily' => 'sans-serif',
            ],
            'height' => 300
        ],
        'title' => [
            'text' => null
        ],
        'subtitle' => [
            'text' => ''
        ],
        'xAxis' => [
            //'type' => 'datetime',
            'categories' => $categories,
            'labels' => [
                'style' => [
                    'fontSize' => '18px',
                    'fontWeight' => 'bold'
                ],
            ],
        ],
        'yAxis' => [
            /*'stackLabels' => [
                'enabled' => true
            ],*/
            //'min' => 0,
            'title' => [
                'text' => 'Total Product'
            ],
            //'gridLineWidth' => 0,
        ],
        'credits' => [
            'enabled' =>false
        ],
        'tooltip' => [
            'enabled' => true,
            'xDateFormat' => '%A, %b %e %Y',
            //'valueSuffix' => ' min'
            //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
        ],
        'plotOptions' => [
            'column' => [
                //'stacking' => 'normal',
                'dataLabels' => [
                    'enabled' => true,
                    'style' => [
                        'fontSize' => '18px',
                        'textOutline' => '0px',
                        'fontWeight' => '0'
                    ],
                ],
                //'borderWidth' => 1,
                //'borderColor' => $color,
            ],
            'series' => [
                'cursor' => 'pointer',
                'point' => [
                    'events' => [
                        'click' => new JsExpression("
                            function(e){
                                e.preventDefault();
                                $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                            }
                        "),
                    ]
                ]
            ]
        ],
        'series' => $data
    ],
]);
?>
    </div>
</div>
<hr>
<table class="table table-responsive" id="progress-tbl">
    <thead>
        <tr>
            <?php
            foreach ($categories as $key => $value) {
                echo '<th>' . $value . '</th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <tr>
        <?php
        foreach ($data_table as $key => $value) {
            ?>
            <td>
                <?php
                foreach ($value as $key2 => $value2) {
                    echo $key2 . ' [<span class="text-yellow">' . $value2 . '</span>]' . '<br/>';
                }
                ?>
            </td>
        <?php }
        ?>
        </tr>
    </tbody>
</table>

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>