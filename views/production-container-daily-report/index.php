<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Monthly Shipping Container <span class="japanesse text-green">(月次コンテナー出荷)</span>',
    'tab_title' => 'Monthly Shipping Container',
    'breadcrumbs_title' => 'Monthly Shipping Container'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

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
print_r($data2);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
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
    <h4>Total Container <span class="japanesse">(コンテナー総本数）</span> : <?= $total_container; ?></h4>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">By Export Date <span class="japanesse">（工場出荷日別）</span></a></li>
        <li class=""><a href="#tab_2" data-toggle="tab">By Port <span class="japanesse">(出荷先港別）</span></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => $title
                    ],
                    'subtitle' => [
                        'text' => $subtitle
                    ],
                    'xAxis' => [
                        'type' => 'category',
                        'categories' => $category,
                        'title' => [
                            'text' => 'Date'
                        ],
                        'labels' => [
                            'formatter' => new JsExpression('function(){ return \'<a href="' . Yii::$app->request->baseUrl . '/serno-output/container-progress?etd=\' + this.value + \'">\' + this.value + \'</a>\'; }'),
                        ],
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Container Completion'
                        ],
                        'stackLabels' => [
                            //'enabled' => true,
                            //'formatter' => new JsExpression('function(){ return this.qty + "aa"; }'),
                        ]
                    ],
                    'tooltip' => [
                        'enabled' => false
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                                'style' => [
                                    'textOutline' => '0px',
                                    'fontWeight' => '0'
                                ],
                                'format' => '{point.qty}/{point.total_qty}',
                                'color' => 'black',
                            ],
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
                                ]
                            ]
                        ]
                    ],
                    'series' => $data
                ],
            ]);
            ?>
        </div>
        <div class="tab-pane" id="tab_2">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/grid-light',
                    //'themes/sand-signika',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'bar',
                        'height' => 600
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => null
                    ],
                    'subtitle' => [
                        'text' => null
                    ],
                    'legend' => [
                        'enabled' => false
                    ],
                    'xAxis' => [
                        'categories' => $category2
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'allowDecimals' => false,
                        'title' => [
                            'text' => 'Qty',
                            'align' => 'high'
                        ],
                        'labels' => [
                            'overflow' => 'justify'
                        ]
                    ],
                    'plotOptions' => [
                        'bar' => [
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.y}'
                            ]
                        ],
                        
                    ],
                    'series' => [
                        [
                            'name' => 'Shipping Stock',
                            'data' => $data2,
                            'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
                        ]
                    ]
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