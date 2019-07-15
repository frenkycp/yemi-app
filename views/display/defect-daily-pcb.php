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
    'page_title' => 'Daily Defect (PCB) <span class="japanesse text-green"></span>',
    'tab_title' => 'Daily Defect (PCB)',
    'breadcrumbs_title' => 'Daily Defect (PCB)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
");

date_default_timezone_set('Asia/Jakarta');

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['defect-daily-pcb']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'year')->dropDownList(
            \Yii::$app->params['year_arr'], [
                //'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'month')->dropDownList(
            $month_arr, [
                //'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'line_pcb')->dropDownList(
            $pcb_line_arr, [
                'prompt' => 'Select Line ...'
                //'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
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
                    //'categories' => $value['category'],
                ],
                'yAxis' => [
                    /*'stackLabels' => [
                        'enabled' => true
                    ],*/
                    //'min' => 0,
                    'title' => [
                        'text' => 'Total NG'
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
                            //'format' => '{point.percentage:.0f}% ({point.qty:.0f})',
                            //'color' => 'black',
                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                            /*'style' => [
                                'textOutline' => '0px',
                                'fontWeight' => '0'
                            ],*/
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

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>