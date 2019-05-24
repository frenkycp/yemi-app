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
    'page_title' => null,
    'tab_title' => 'Machine Operation Status',
    'breadcrumbs_title' => 'Machine Operation Status'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data_iot);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['mnt-kwh-report/index']),
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
    <div class="col-md-6">
        <label for="machine_id" class="control-label">Machine</label>
        <?= Select2::widget([
            'id' => 'machine_id',
            'name' => 'machine_id',
            'value' => $machine_id,
            'data' => ArrayHelper::map(app\models\AssetTbl::find()->where(['like', 'asset_id', 'MNT%', false])->all(), 'asset_id', 'assetName'),
            'options' => ['placeholder' => 'Select states ...', 'class' => 'form-control', 'onchange'=>'this.form.submit()',]
        ]); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<!--<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Power Consumption</a></li>
        <li><a href="#tab_2" data-toggle="tab">Machine Operation Status</a></li>
        <li><a href="#tab_3" data-toggle="tab">Machine Operation Status (By Hours)</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            
        </div>
    </div>
</div>-->

<div class="box box-primary box-solid">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/sand-signika',
                    //'themes/grid-light',
                    'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 350
                    ],
                    'title' => [
                        'text' => 'Machine Operation Status'
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        //'categories' => $value['category'],
                    ],
                    'yAxis' => [
                        //'min' => 0,
                        'title' => [
                            'text' => 'Percentage'
                        ],
                        //'gridLineWidth' => 0,
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'xDateFormat' => '%A, %b %e %Y',
                        'valueSuffix' => ' min'
                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'percent',
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
                    'series' => $data_iot
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<div class="box box-primary box-solid">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/grid-light',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 350,
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => 'Machine Operation Status (By Hours)',
                    ],
                    'xAxis' => [
                        'categories' => $categories,
                        'title' => [
                            'text' => 'Working Hour'
                        ]
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'PERCENT',
                            //'rotation' => 0,
                            //'align' => 'high'
                        ]
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'valueSuffix' => ' seconds'
                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.percentage:.1f}%',
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
                    ],
                    'series' => $data_iot_by_hours,
                ],
            ]);

            ?>
        </div>
    </div>
</div>

<!--<div class="box box-primary box-solid" style="display: none;">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            /*echo ''; Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/grid-light',
                    'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'spline',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 400,
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => 'Power Consumption',
                    ],
                    'xAxis' => [
                        'categories' => $categories,
                        'title' => [
                            'text' => 'Working Hour'
                        ]
                    ],
                    'tooltip' => [
                        //'pointFormat' => 'Power Consumption: <b>{point.y}</b><br/>',
                        'valueSuffix' => ' KWH'
                    ],
                    'yAxis' => [
                        [
                            'title' => [
                                'text' => 'KWH',
                                'rotation' => 0,
                                'align' => 'high'
                            ]
                        ],
                        [
                            'title' => [
                                'text' => 'KWH',
                                'rotation' => 0,
                                'align' => 'high'
                            ],
                            'opposite' => true
                        ],
                    ],
                    'series' => $data,
                ],
            ]);*/

            ?>
        </div>
        
    </div>
</div>-->