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
    'page_title' => 'Production Manpower <span class="japanesse text-green"></span>',
    'tab_title' => 'Production Manpower',
    'breadcrumbs_title' => 'Production Manpower'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
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

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['display/daily-prod-attendance']),
]); ?>

<div class="row">
    <div class="col-md-4">
        <?php echo '<label class="control-label">Select date range</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'from_date',
            'attribute2' => 'to_date',
            'options' => ['placeholder' => 'Start date', 'onchange' => 'this.form.submit()'],
            'options2' => ['placeholder' => 'End date', 'onchange' => 'this.form.submit()'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<br/>
<div class="box box-primary">
    <div class="box-body">
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
                    'text' => null
                ],
                'subtitle' => [
                    'text' => ''
                ],
                'xAxis' => [
                    'type' => 'datetime',
                ],
                'yAxis' => [
                    'stackLabels' => [
                        'enabled' => true,
                    ],
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => false,
                        ],
                        'maxPointWidth' => 50,
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'dataLabels' => [
                            //'allowOverlap' => true
                            'enabled' => true
                        ],
                        /**/'point' => [
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

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>