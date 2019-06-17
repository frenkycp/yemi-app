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
    'tab_title' => 'Machine Utility',
    'breadcrumbs_title' => 'Machine Utility'
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
print_r($data['day']['series']);
echo '</pre>';
echo '<pre>';
print_r($data['day']['drilldown_series']);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['mnt-iot-utility/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'year')->dropDownList(\Yii::$app->params['year_arr']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'month')->dropDownList([
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'machine_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(app\models\AssetTbl::find()->where(['like', 'asset_id', 'MNT%', false])->all(), 'asset_id', 'assetName'),
            'options' => ['placeholder' => 'Select a machine ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-success', 'style' => 'margin-top: 5px;']); ?>
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
                    'modules/data',
                    'modules/drilldown',
                    'themes/grid-light',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => 'Machine Utility',
                    ],
                    'xAxis' => [
                        'type' => 'category',
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Percentage',
                        ]
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'valueSuffix' => ' %'
                    ],
                    'legend' => [
                        'enabled' => false
                    ],
                    'plotOptions' => [
                        'series' => [
                            'borderWidth' => 0,
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.y}%'
                            ],
                        ],
                    ],
                    'series' => $data['day']['series'],
                    'drilldown' => [
                        'series' => $data['day']['drilldown_series']
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>