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
    'page_title' => 'Stock Taking Progress',
    'tab_title' => 'Stock Taking Progress',
    'breadcrumbs_title' => 'Stock Taking Progress'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
");

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

// echo '<pre>';
// print_r($data_completion);
// echo '</pre>';
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['progress']),
]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'period')->dropDownList($period_arr, [
            'prompt' => 'Choose period...'
        ]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-success', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>


<div class="panel panel-primary" style="<?= $model->period != null ? '' : 'display: none;'; ?>">
    <div class="panel-heading">
        <h3 class="panel-title">Closing Progress</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $total_ng; ?></h3>

                        <p>Fix Asset NG</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?= $total_ng == 0 ? '#' : Url::to(['asset-log', 'schedule_id' => $model->period, 'status' => 'NG']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $total_no_label; ?></h3>

                        <p>No Label</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?= $total_no_label == 0 ? '#' : Url::to(['asset-log', 'schedule_id' => $model->period, 'label' => 'N']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $total_propose_scrap; ?></h3>

                        <p>Propose Scrap</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?= $total_propose_scrap == 0 ? '#' : Url::to(['asset-log', 'schedule_id' => $model->period, 'propose_scrap' => 'Y']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <hr style="border-top: 1px solid silver; margin: 0px;">
        <div class="row">
            <div class="col-md-12">
                <?=
                Highcharts::widget([
                    'scripts' => [
                        //'modules/exporting',
                        //'themes/sand-signika',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'pie',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'plotBackgroundColor' => null,
                            'plotBorderWidth' => null,
                            'plotShadow' => false,
                        ],
                        'title' => [
                            'text' => null
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'tooltip' => [
                            'pointFormat' => '{series.name}: <b>{point.percentage:.2f}% ({point.y})</b>',
                        ],
                        'plotOptions' => [
                            'pie' => [
                                // 'allowPointSelect' => true,
                                // 'cursor' => 'pointer',
                                'dataLabels' => [
                                    'enabled' => true,
                                    'format' => '<b>{point.name}</b>: {point.percentage:.2f}% ({point.y})'
                                ],
                            ],
                            'series' => [
                                'cursor' => 'pointer',
                                'point' => [
                                    'events' => [
                                        'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    ]
                                ]
                            ],
                        ],
                        'series' => $data_completion
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>