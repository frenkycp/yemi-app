<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Monthly Overtime Control <span class="japanesse light-green">(月次残業管理)</span>',
    'tab_title' => 'Monthly Overtime Control',
    'breadcrumbs_title' => 'Monthly Overtime Control'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

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
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
");

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

?>
<?php
/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<?php $form = ActiveForm::begin([
    'id' => 'form_index',
    'method' => 'get',
    'action' => Url::to(['display/hrga-spl-report-daily']),
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
                $year_arr, [
                    'class' => 'form-control',
                    'onchange'=>'this.form.submit()'
                ]
            ); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'month')->dropDownList(
                $month_arr, [
                    'class' => 'form-control',
                    'onchange'=>'this.form.submit()'
                ]
            ); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

<div class="box box-primary">
    <div class="box-header">
        <h5 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h5>
    </div>
    <div class="box-body">
        <?php
        if (\Yii::$app->request->get('id') == 'hour') {
            ?>
            <div class="panel panel-info">
                <div class="panel-body">
                    <p style="font-size: 22px;">Production <span class="japanesse">(生産課)</span>  - Actual/Budget <span class="japanesse">(実績/予算)</span> : <?= '<b>' . $prod_total_jam_lembur . '</b> / ' . $overtime_budget; ?> hours</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active <?= $progress_bar; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $budget_progress; ?>%; min-width: 1em"><?= $budget_progress; ?>%</div>
                    </div>
                    <hr>
                    <p style="font-size: 22px;">Office & Others <span class="japanesse">(事務所とその他)</span> - Actual/Budget <span class="japanesse">(実績/予算)</span> : <?= '<b>' . $others_total_jam_lembur . '</b> / ' . $overtime_budget2; ?> hours</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active <?= $progress_bar2; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $budget_progress2; ?>%; min-width: 1em"><?= $budget_progress2; ?>%</div>
                    </div>
                </div>
            </div>
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                    //'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 450,
                        'style' => [
                            'fontFamily' => 'sans-serif'
                        ],
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'title' => [
                        'text' => $title
                    ],
                    'subtitle' => [
                        'text' => $subtitle
                    ],
                    'xAxis' => [
                        'categories' => $category,
                        'title' => [
                            'text' => 'Date',
                            'style' => [
                                'fontSize' => '18px',
                                'fontWeight' => 'bold'
                            ],
                        ],
                        'labels' => [
                            'style' => [
                                'fontSize' => '16px',
                                'fontWeight' => 'bold'
                            ],
                        ],
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'title' => [
                            'text' => 'Total Hour'
                        ],
                        'stackLabels' => [
                            'enabled' => true,
                            'style' => [
                                //'color' => 'white',
                                'fontWeight' => 'bold',
                                'fontSize' => '20px',
                            ],
                        ],
                    ],
                    'legend' => [
                        'enabled' => true,
                        'itemStyle' => [
                            'fontSize' => '20px',
                        ],
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => false,
                                'style' => [
                                    'textOutline' => '0px',
                                    'fontWeight' => '0'
                                ],
                            ]
                        ],
                        /*'series' => [
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
                        ]*/
                    ],
                    'series' => $data2
                ],
            ]);
        } elseif (\Yii::$app->request->get('id') == 'emp') {
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                    //'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 400,
                        'style' => [
                            'fontFamily' => 'sans-serif'
                        ],
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'title' => [
                        'text' => $title
                    ],
                    'subtitle' => [
                        'text' => $subtitle
                    ],
                    'xAxis' => [
                        'categories' => $category,
                        'labels' => [
                            'style' => [
                                'fontSize' => '16px',
                                'fontWeight' => 'bold'
                            ],
                        ],
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'title' => [
                            'text' => 'Total Employee'
                        ],
                        'stackLabels' => [
                            'enabled' => true,
                            'style' => [
                                //'color' => 'white',
                                'fontWeight' => 'bold',
                                'fontSize' => '20px',
                            ],
                        ],
                    ],
                    'legend' => [
                        'enabled' => true,
                        'itemStyle' => [
                            'fontSize' => '16px',
                        ],
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => false,
                                'style' => [
                                    'textOutline' => '0px',
                                    'fontWeight' => '0'
                                ],
                            ]
                        ],
                        /*'series' => [
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
                        ]*/
                    ],
                    'series' => $data
                ],
            ]);
        }
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