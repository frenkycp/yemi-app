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
    'tab_title' => 'Machine Daily Power Consumption',
    'breadcrumbs_title' => 'Machine Daily Power Consumption'
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

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['mnt-power-consumption/index']),
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

<div class="box box-primary box-solid">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
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
            ]);

            ?>
        </div>
        
    </div>
</div>