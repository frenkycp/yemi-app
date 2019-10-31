<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'FA Line (All) Efficiency <span class="japanesse text-green"></span>',
    'tab_title' => 'FA Line (All) Efficiency',
    'breadcrumbs_title' => 'FA Line (All) Efficiency'
];
$color = 'ForestGreen';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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
print_r($data2);
echo '</pre>';*/

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['index']),
]); ?>

<div class="row">
    <div class="col-md-4">
        <?php echo '<label class="control-label">Select date range</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'from_date',
            'attribute2' => 'to_date',
            'options' => ['placeholder' => 'Start date'],
            'options2' => ['placeholder' => 'End date'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="panel panel-primary">
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
                //'themes/sand-signika',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'line',
                    'style' => [
                        'fontFamily' => 'Source Sans Pro'
                    ],
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
                /*'legend' => [
                    'enabled' => false,
                ],*/
                'xAxis' => [
                    //'categories' => $categories,
                    'type' => 'datetime',
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Percentage (%)'
                    ],
                    'min' => 0,
                    //'max' => $max,
                    /*'plotLines' => [
                        [
                            'value' => $target_eff,
                            'color' =>  '#00FF00',
                            'width' => 2,
                            'zIndex' => 0,
                            'label' => ['text' => '']
                        ]
                    ],*/
                    //'max' => 100,
                ],
                'tooltip' => [
                    //'shared' => true,
                    //'crosshairs' => true,
                    'xDateFormat' => '%Y-%m-%d',
                    'valueSuffix' => '%',
                ],
                'plotOptions' => [
                    'series' => [
                        'marker' => [
                            'enabled' => false
                        ],
                    ],
                    /*'series' => [
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
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ]
                    ],*/
                    'line' => [
                        'dataLabels' => [
                            'enabled' => false
                        ],
                    ],
                ],
                'series' => $data,
            ],
        ]); ?>
    </div>
</div>