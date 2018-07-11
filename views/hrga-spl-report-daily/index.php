<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Monthly Overtime Control <span class="japanesse text-green">(月次残業管理)</span>',
    'tab_title' => 'Monthly Overtime Control',
    'breadcrumbs_title' => 'Monthly Overtime Control'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse {
        font-family: 'MS PGothic', Osaka, Arial, sans-serif;
    }
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
                $year_arr
            ); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'month')->dropDownList(
                $month_arr
            ); ?>
        </div>
        <button type="submit" class="btn btn-default">Update Chart</button>
    </div>

<?php ActiveForm::end(); ?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Total Hour <span class="japanesse">(時間)</span></a></li>
        <li><a href="#tab_2" data-toggle="tab">Total Employee <span class="japanesse">(人員)</span></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <?php
            $progress_bar = 'progress-bar-success';
            $progress_bar2 = 'progress-bar-info';
            /*if ($budget_progress > 75) {
                $progress_bar = 'progress-bar-warning';
            }
            if ($budget_progress > 100) {
                $progress_bar = 'progress-bar-danger';
            }*/
            ?>
            <div class="panel panel-info">
                <div class="panel-body">
                    <p>Production <span class="japanesse">(生産課)</span>  - Actual/Budget <span class="japanesse">(実績/予算)</span> : <?= '<b>' . $prod_total_jam_lembur . '</b> / ' . $overtime_budget; ?> hours</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active <?= $progress_bar; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $budget_progress; ?>%; min-width: 1em"><?= $budget_progress; ?>%</div>
                    </div>
                    <hr>
                    <p>Office & Others <span class="japanesse">(事務所とその他)</span> - Actual/Budget <span class="japanesse">(実績/予算)</span> : <?= '<b>' . $others_total_jam_lembur . '</b> / ' . $overtime_budget2; ?> hours</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active <?= $progress_bar2; ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $budget_progress2; ?>%; min-width: 1em"><?= $budget_progress2; ?>%</div>
                    </div>
                </div>
            </div>
            
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/grid-light',
                    //'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 300,
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
                            'text' => 'Date'
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
                                'fontWeight' => 'bold',
                                //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                            ]
                        ]
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
                        'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('
                                        function(){
                                            $("#modal2").modal("show").find(".modal-body").html(this.options.remark);
                                        }
                                    '),
                                    //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                                ]
                            ]
                        ]
                    ],
                    'series' => $data2
                ],
            ]);
            yii\bootstrap\Modal::begin([
                'id' =>'modal2',
                'header' => '<h3>Detail Information</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();
            ?>
            
        </div>
        
        <div class="tab-pane" id="tab_2">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/grid-light',
                    //'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 350,
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
                        'categories' => $category
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'title' => [
                            'text' => 'Total Employee'
                        ],
                        'stackLabels' => [
                            'enabled' => true,
                            'style' => [
                                'fontWeight' => 'bold',
                                //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                            ]
                        ]
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
                    'series' => $data
                ],
            ]);
            yii\bootstrap\Modal::begin([
                'id' =>'modal',
                'header' => '<h3>Detail Information</h3>',
                'size' => 'modal-lg',
            ]);
            yii\bootstrap\Modal::end();
        ?>
        </div>
    </div>
</div>