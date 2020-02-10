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
    'page_title' => 'Uncountable Parts Stock Take Top Variance (Weekly) <span class="japanesse light-green"></span>',
    'tab_title' => 'Uncountable Parts Stock Take Top Variance (Weekly)',
    'breadcrumbs_title' => 'Uncountable Parts Stock Take Top Variance (Weekly)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
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
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['parts-uncountable-chart']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'post_date')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'options' => [
                'placeholder' => 'Enter date ...',
                'class' => 'form-control',
                'onchange'=>'this.form.submit()',
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label('Date'); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Top Variance (Absolute)</h3>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    //'zoomType' => 'x',
                    //'height' => $height,
                    'type' => 'column',
                    'style' => [
                        //'fontFamily' => 'Source Sans Pro'
                    ],
                ],
                'title' => [
                    'text' => null,
                ],
                'credits' => [
                    'enabled' => false
                ],
                'xAxis' => [
                    'type' => 'category',
                    //'categories' => $value['categories']
                ],
                'yAxis' => [
                    'title' => [
                        'enabled' => true,
                        //'text' => $value['uom'],
                    ],
                    //'plotBands' => $plotBands,
                ],
                'tooltip' => [
                    'enabled' => true,
                    //'xDateFormat' => '%Y-%m-%d',
                    //'valueSuffix' => ' ' . $value['uom'],
                ],
                'series' => $data1,
            ],
        ]);
        ?>
    </div>
</div>

<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Top Variance (Surplus)</h3>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    //'zoomType' => 'x',
                    //'height' => $height,
                    'type' => 'column',
                    'style' => [
                        //'fontFamily' => 'Source Sans Pro'
                    ],
                ],
                'title' => [
                    'text' => null,
                ],
                'credits' => [
                    'enabled' => false
                ],
                'xAxis' => [
                    'type' => 'category',
                    //'categories' => $value['categories']
                ],
                'yAxis' => [
                    'title' => [
                        'enabled' => true,
                        //'text' => $value['uom'],
                    ],
                    //'plotBands' => $plotBands,
                ],
                'tooltip' => [
                    'enabled' => true,
                    //'xDateFormat' => '%Y-%m-%d',
                    //'valueSuffix' => ' ' . $value['uom'],
                ],
                'series' => $data2,
            ],
        ]);
        ?>
    </div>
</div>

<div class="box box-solid box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Top Variance (Defisit)</h3>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    //'zoomType' => 'x',
                    //'height' => $height,
                    'type' => 'column',
                    'style' => [
                        //'fontFamily' => 'Source Sans Pro'
                    ],
                ],
                'title' => [
                    'text' => null,
                ],
                'credits' => [
                    'enabled' => false
                ],
                'xAxis' => [
                    'type' => 'category',
                    //'categories' => $value['categories']
                ],
                'yAxis' => [
                    'title' => [
                        'enabled' => true,
                        //'text' => $value['uom'],
                    ],
                    //'plotBands' => $plotBands,
                ],
                'tooltip' => [
                    'enabled' => true,
                    //'xDateFormat' => '%Y-%m-%d',
                    //'valueSuffix' => ' ' . $value['uom'],
                ],
                'series' => $data3,
            ],
        ]);
        ?>
    </div>
</div>