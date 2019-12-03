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
    'page_title' => 'GO-Machine <span class="japanesse light-green">[ 切替段取り ]</span> Request',
    'tab_title' => 'Go Machine Order',
    'breadcrumbs_title' => 'Go Machine Order'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
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
    .form-horizontal .control-label {padding-top: 0px;}
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['go-machine-order']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'request_date')->widget(DatePicker::classname(), [
            'options' => [
                'type' => DatePicker::TYPE_INPUT,
                'onchange'=>'this.form.submit()'
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ]); ?>
        
    </div>
</div>

<?php ActiveForm::end(); ?>
<div class="box box-primary box-solid">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/sand-signika',
                    'themes/grid-light',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 500
                    ],
                    'title' => [
                        'text' => 'GO-Machine [ 切替段取り ] Request'
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        'min' => (strtotime($model->request_date . ' 00:00:00' . " +7 hours") * 1000),
                        'max' => (strtotime($model->request_date . ' 23:00:00' . " +7 hours") * 1000)
                        //'categories' => $value['category'],
                    ],
                    'yAxis' => [
                        //'min' => 0,
                        'title' => [
                            'text' => 'Qty'
                        ],
                        'stackLabels' => [
                            'enabled' => true,
                        ],
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        //'xDateFormat' => '%A, %b %e %Y',
                        //'valueSuffix' => ' min'
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                                //'format' => '{point.percentage:.1f}%',
                                //'format' => '{point.percentage:.0f}%',
                            ],
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
                        ],
                    ],
                    'series' => $data
                ],
            ]);
            ?>
        </div>
    </div>
</div>

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>