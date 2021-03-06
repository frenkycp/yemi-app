<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'SMT INJ Efficiency, Utility & Loss Time Management (Monthly)<span class="japanesse text-green"></span>',
    'tab_title' => 'SMT INJ Efficiency, Utility & Loss Time Management',
    'breadcrumbs_title' => 'SMT INJ Efficiency, Utility & Loss Time Management'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .modal-lg { width: 1300px;}
");

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

date_default_timezone_set('Asia/Jakarta');

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['smt-line-monthly-utility/index']),
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
    <div class="col-md-2">
        <?= $form->field($model, 'loc')->dropDownList($loc_dropdown, [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ])->label('Location'); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'type')->dropDownList([
            1 => 'Line 1 V.S Line 2',
            2 => 'Total',
        ], [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ])->label('Data Type'); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<h4 class="box-title">Last Update : <?= date('Y-m-d H:i:s') ?></h4>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Working Ratio <span class="japanesse">（稼働率）</a></li>
        <li><a href="#tab_2" data-toggle="tab">Operation Ratio <span class="japanesse">（操業率）</span></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
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
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'Source Sans Pro'
                        ],
                    ],
                    'title' => [
                        'text' => null
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'xAxis' => [
                        'categories' => $categories,
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Percentage (%)'
                        ],
                        'min' => 0,
                        //'max' => 100,
                    ],
                    'plotOptions' => [
                        'column' => [
                            'dataLabels' => [
                                'enabled' => true,
                                'allowOverlap' => true
                            ],
                        ],
                    ],
                    'series' => $data['working_ratio']
                ],
            ]);
            ?>
        </div>
        <div class="tab-pane" id="tab_2">
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
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'Source Sans Pro'
                        ],
                    ],
                    'title' => [
                        'text' => null
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'xAxis' => [
                        'categories' => $categories,
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Percentage (%)'
                        ],
                        'min' => 0,
                        //'max' => 100,
                    ],
                    'plotOptions' => [
                        'column' => [
                            'dataLabels' => [
                                'enabled' => true,
                                'allowOverlap' => true
                            ],
                        ],
                    ],
                    'series' => $data['operation_ratio']
                ],
            ]);
            ?>
        </div>
    </div>
</div>