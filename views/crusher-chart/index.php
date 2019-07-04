<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Crusher <span class="text-green japanesse"></span>',
    'tab_title' => 'Crusher',
    'breadcrumbs_title' => 'Crusher'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

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
print_r($data);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['crusher-chart/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
        'options' => [
            'type' => DatePicker::TYPE_INPUT,
        ],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
        'options' => [
            'type' => DatePicker::TYPE_INPUT,
        ],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-success', 'style' => 'margin-top: 5px;']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::a('VIEW ALL DATA', ['crusher-tbl/index'], ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;', 'target' => '_blank']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="box box-primary box-solid">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/sand-signika',
                    'themes/grid-light',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'zoomType' => 'x',
                        'height' => 500
                    ],
                    'title' => [
                        'text' => 'CRUSHER'
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        //'min' => $start_date,
                        //'max' => $end_date
                        //'categories' => $value['category'],
                    ],
                    'yAxis' => [
                        //'min' => 0,
                        'title' => [
                            'text' => 'Kg'
                        ],
                        'stackLabels' => [
                            'enabled' => true,
                        ],
                        //'gridLineWidth' => 0,
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'xDateFormat' => '%A, %e %b %Y',
                        'valueSuffix' => ' Kg'
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                                //'format' => '{point.percentage:.1f}%',
                            ],
                        ],
                    ],
                    'series' => $data
                ],
            ]);
            ?>
        </div>
    </div>
</div>