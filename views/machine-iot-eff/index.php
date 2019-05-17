<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Machine Availability & Efficiency <span class="text-green japanesse"></span>',
    'tab_title' => 'Machine Availability & Efficiency',
    'breadcrumbs_title' => 'Machine Availability & Efficiency'
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
print_r($loc);
echo '</pre>';

echo '<pre>';
print_r($data['availability']['data']);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['machine-iot-eff/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="posting_date" class="control-label">Date</label>
            <?= DatePicker::widget([
                'id' => 'posting_date',
                'name' => 'posting_date',
                'type' => DatePicker::TYPE_INPUT,
                'value' => $posting_date,
                'options' => [
                    'onchange'=>'this.form.submit()',
                ],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="box box-primary">
    <div class="box-body">
        <div class="col-md-12">
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
                        //'zoomType' => 'x'
                        'height' => 350
                    ],
                    'title' => [
                        'text' => 'MACHINE AVAILABILITY'
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'categories' => $data['availability']['categories'],
                    ],
                    'yAxis' => [
                        //'min' => 0,
                        'title' => [
                            'text' => 'Percentage'
                        ],
                        'max' => 100,
                        //'gridLineWidth' => 0,
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        //'xDateFormat' => '%A, %b %e %Y',
                        'valueSuffix' => ' %'
                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            //'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                            ],
                        ],
                        /**/'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                                ]
                            ],
                            'maxPointWidth' => 50
                        ]
                    ],
                    'series' => $data['availability']['data'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-body">
        <div class="col-md-12">
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
                        //'zoomType' => 'x'
                        'height' => 350
                    ],
                    'title' => [
                        'text' => 'MACHINE EFFICIENCY'
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'categories' => $data['efficiency']['categories'],
                    ],
                    'yAxis' => [
                        //'min' => 0,
                        'title' => [
                            'text' => 'Percentage'
                        ],
                        'max' => 100,
                        //'gridLineWidth' => 0,
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        //'xDateFormat' => '%A, %b %e %Y',
                        'valueSuffix' => ' %'
                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            //'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                            ],
                        ],
                        /**/'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                                ]
                            ],
                            'maxPointWidth' => 50
                        ]
                    ],
                    'series' => $data['efficiency']['data'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>