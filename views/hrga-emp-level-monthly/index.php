<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->title = Yii::t('app', 'Employee Data Monthly');
$this->title = [
    'page_title' => 'Manpower Planning by Status  <span>(要員計画・雇用形態別)</span>',
    'tab_title' => 'Manpower Planning by Status',
    'breadcrumbs_title' => 'Manpower Planning by Status'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => Url::to(['index']),
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
        <div class="col-md-3" style="display: none;">
            <?= $form->field($model, 'month')->dropDownList(
                $month_arr
            ); ?>
        </div>
        <?= Yii::$app->params['update_chart_btn']; ?>
    </div>

<?php ActiveForm::end(); ?>

<div class="box box-success">
    <div class="box-header with-border">
        <h4 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h4>
    </div>
    <div class="box-body no-padding">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                $menu == 2 ? 'themes/grid-light' : 'themes/sand-signika',
                // 'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 500,
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
                    [
                        'labels' => [
                            'format' => '{value}',
                            'style' => [
                                //'color' => Highcharts.getOptions().colors[1]
                            ]
                        ],
                        'title' => [
                            'text' => 'Total Employee (人数)',
                            'style' => [
                                'font-family' => "'MS PGothic', Osaka, Arial, sans-serif"
                                //'color' => Highcharts.getOptions().colors[1]
                            ]
                        ],
                        'max' => 2500,
                        
                        'stackLabels' => [
                            'enabled' => true,
                            'allowOverlap' => true,
                            'style' => [
                                'fontWeight' => 'bold',
                                //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                            ]
                        ]
                    ],
                    [//primary axis
                        'labels' => [
                            'format' => '{value}',
                            'style' => [
                                //'color' => Highcharts.getOptions().colors[1]
                            ]
                        ],
                        'title' => [
                            'text' => 'Total Production Qty exclude KD  (生産台数・KDを含まない)',
                            'style' => [
                                'font-family' => "'MS PGothic', Osaka, Arial, sans-serif",
                                //'color' => Highcharts.getOptions().colors[1]
                            ]
                        ],
                        'min' => 0,
                        'max' => 6000,
                        'opposite' => true,
                    ],
                    
                    /*'min' => 0,
                    'title' => [
                        'text' => 'Total fruit consumption'
                    ],
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            'fontWeight' => 'bold',
                            //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        ]
                    ]*/
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => $menu == 2 ? false : true,
                            'style' => [
                                'textOutline' => '0px',
                                'fontSize' => '10px',
                                'fontWeight' => '0'
                            ],
                            //'allowOverlap' => \Yii::$app->request->get('menu') !== null ? false : true,
                            //'color' => 'Black'
                            //color => (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        ]
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ]
                    ]
                ],
                'series' => $data
            ],
        ]);
        ?>
        <hr/>
        <?php
        /*echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
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
                        'text' => 'Total fruit consumption'
                    ],
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            'fontWeight' => 'bold',
                            //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        ]
                    ]
                ],
                'series' => $data
            ],
        ]);*/
        ?>
    </div>
</div>