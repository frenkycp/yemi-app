<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    'page_title' => 'Monthly Production Inspection Chart <span class="japanesse light-green">(月次出荷管理検査)</span>',
    'tab_title' => 'Monthly Production Inspection Chart',
    'breadcrumbs_title' => 'Monthly Production Inspection Chart'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

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
/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<?php $form = ActiveForm::begin([
    'id' => 'form_index',
    'method' => 'get',
    'action' => Url::to(['display/production-monthly-inspection']),
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 //'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-7',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'year')->dropDownList(
                \Yii::$app->params['year_arr'], [
                    'onchange'=>'this.form.submit()'
                ]
            ); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'month')->dropDownList(
                $month_arr, [
                    'onchange'=>'this.form.submit()'
                ]
            ); ?>
        </div>
        
    </div>
<hr/>
<?php ActiveForm::end(); ?>
<div class="box box-info">
    <div class="box-header with-border">
        <h4 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h4>
    </div>
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
                    'height' => 650
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => null
                ],
                'subtitle' => [
                    'text' => null
                ],
                'legend' => [
                    'enabled' => true,
                    'itemStyle' => [
                        'fontSize' => '26px',
                    ],
                ],
                'xAxis' => [
                    'type' => 'category',
                    'categories' => $categories,
                    'labels' => [
                        'style' => [
                            'fontSize' => '14px',
                            'fontWeight' => 'bold'
                        ],
                    ],
                ],
                'plotOptions' => [
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                /*'click' => new JsExpression('
                                    function(){
                                        $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                    }
                                '),*/
                            ]
                        ],
                        'dataLabels' => [
                            'enabled' => true,
                            'style' => [
                                //'color' => 'white',
                                'fontWeight' => 'bold',
                                'fontSize' => '26px',
                            ],
                        ],
                    ],
                    'column' => [
                        'stacking' => 'normal'
                    ],
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Qty'
                    ],
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