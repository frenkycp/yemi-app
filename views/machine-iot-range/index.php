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
    'page_title' => 'Machine Efficiency (By Range) <span class="text-green japanesse"></span>',
    'tab_title' => 'Machine Efficiency (By Range)',
    'breadcrumbs_title' => 'Machine Efficiency (By Range)'
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
    'action' => Url::to(['machine-iot-range/index']),
]); ?>

<div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'machine_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(app\models\AssetTbl::find()->where(['like', 'asset_id', 'MNT%', false])->all(), 'asset_id', 'assetName'),
        'options' => [
            'placeholder' => 'Select a machine ...',
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'maximumSelectionLength' => 5
        ],
    ]); ?>
    </div>
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
</div>

<div class="form-group">
    <?= Html::submitButton('GENERATE', ['class' => 'btn btn-success', 'style' => 'margin-top: 5px;']); ?>
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
                    //'themes/grid-light',
                    'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'line',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'zoomType' => 'x'
                        //'height' => 350
                    ],
                    'title' => [
                        'text' => 'Machine Utility'
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
                            'text' => 'Percentage'
                        ],
                        //'gridLineWidth' => 0,
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        //'shared' => true,
                        //'xDateFormat' => '%A, %b %e %Y',
                        'valueSuffix' => '%'
                    ],
                    'plotOptions' => [
                        'line' => [
                            //'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => false,
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