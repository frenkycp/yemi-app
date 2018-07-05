<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Weekly Overtime <span class="japanesse text-green">(週次残業管理）</span>',
    'tab_title' => 'Weekly Overtime',
    'breadcrumbs_title' => 'Weekly Overtime'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');

$this->registerCss(".tab-content > .tab-pane,
.pill-content > .pill-pane {
    display: block;     
    height: 0;          
    overflow-y: hidden; 
}

.tab-content > .active,
.pill-content > .active {
    height: auto;       
} ");

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
        <li class="active"><a href="#tab_1" data-toggle="tab">Total Employee</a></li>
        <li><a href="#tab_2" data-toggle="tab">Total Hour</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
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
    </div>
</div>