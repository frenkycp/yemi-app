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
    'page_title' => 'NG Summary (Cause by Man)',
    'tab_title' => 'NG Chart (Cause by Man)',
    'breadcrumbs_title' => 'NG Chart (Cause by Man)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .tab-content > .tab-pane,
    .pill-content > .pill-pane {
        display: block;     
        height: 0;          
        overflow-y: hidden; 
    }

    .tab-content > .active,
    .pill-content > .active {
        height: auto;
    }
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

$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#myTable').DataTable({
        'pageLength': 15,
        'order': [[ 4, 'desc' ]]
    });
    $('#myTable').on('click', '.popupModal', function (e) {
        e.preventDefault();
        $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
    } );
});");

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['ng-chart']),
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
        <?= $form->field($model, 'location')->dropDownList(\Yii::$app->params['wip_location_arr'], [
            'prompt' => 'Choose Location...'
        ]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<br/>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Daily NG (Total NG : <?= number_format($total_ng); ?>)</h3>
            </div>
            <div class="panel-body no-padding">
                <?php
                echo count($ng_data_daily) == 0 ? '&nbsp;&nbsp;&nbsp;No NG (Man Category)...' : Highcharts::widget([
                    'scripts' => [
                        //'modules/exporting',
                        //'themes/grid-light',
                        'themes/dark-unica',
                        //'themes/sand-signika',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'column',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'zoomType' => 'x',
                            'height' => 300,
                        ],
                        'credits' => [
                            'enabled' => false
                        ],
                        'title' => [
                            'text' => null,
                        ],
                        'xAxis' => [
                            'type' => 'datetime',
                            'gridLineWidth' => 0
                        ],
                        'yAxis' => [
                            'title' => [
                                'text' => 'Total NG',
                            ],
                            'stackLabels' => [
                                'enabled' => true,
                            ],
                            //'max' => 60,
                            //'tickInterval' => 10
                        ],
                        'tooltip' => [
                            'enabled' => true,
                            'valueSuffix' => '%'
                        ],
                        'plotOptions' => [
                            'column' => [
                                'marker' => [
                                    'enabled' =>false
                                ],
                                'stacking' => 'normal',
                                'dataLabels' => [
                                    'enabled' => true,
                                ],
                                'maxPointWidth' => 50
                            ],
                            'series' => [
                                'lineWidth' => 1,
                                //'showInLegend' => false,
                                //'color' => new JsExpression('Highcharts.getOptions().colors[0]')
                            ],
                        ],
                        'series' => $ng_data_daily,
                    ],
                ]);

                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">NG By Contract Status</h3>
                    </div>
                    <div class="panel-body no-padding">
                        <?php
                        echo count($ng_data_contract) == 0 ? '&nbsp;&nbsp;&nbsp;No NG (Man Category)...' : Highcharts::widget([
                            'scripts' => [
                                //'modules/exporting',
                                //'themes/sand-signika',
                                //'themes/grid-light',
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
                                    'height' => 300,
                                ],
                                'title' => [
                                    'text' => null
                                ],
                                'credits' => [
                                    'enabled' =>false
                                ],
                                'tooltip' => [
                                    'pointFormat' => '{series.name}: <b>{point.percentage:.0f}% ({point.y} NG)</b>',
                                ],
                                'plotOptions' => [
                                    'pie' => [
                                        // 'allowPointSelect' => true,
                                        // 'cursor' => 'pointer',
                                        'dataLabels' => [
                                            'enabled' => true,
                                            'format' => '<b>{point.name}</b>: {point.percentage:.0f}% ({point.y} NG)'
                                        ],
                                    ],
                                ],
                                'series' => $ng_data_contract
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">NG By Section</h3>
                    </div>
                    <div class="panel-body no-padding">
                        <?php
                        echo count($ng_data_section) == 0 ? '&nbsp;&nbsp;&nbsp;No NG (Man Category)...' : Highcharts::widget([
                            'scripts' => [
                                //'modules/exporting',
                                //'themes/sand-signika',
                                //'themes/grid-light',
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
                                    'height' => 300,
                                ],
                                'title' => [
                                    'text' => null
                                ],
                                'credits' => [
                                    'enabled' =>false
                                ],
                                'tooltip' => [
                                    'pointFormat' => '{series.name}: <b>{point.percentage:.0f}% ({point.y} NG)</b>',
                                ],
                                'plotOptions' => [
                                    'pie' => [
                                        // 'allowPointSelect' => true,
                                        // 'cursor' => 'pointer',
                                        'dataLabels' => [
                                            'enabled' => true,
                                            'format' => '<b>{point.name}</b>: {point.percentage:.0f}% ({point.y} NG)'
                                        ],
                                    ],
                                ],
                                'series' => $ng_data_section
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">NG By PIC</h3>
            </div>
            <div class="panel-body">
                <table id="myTable" class="table">
                    <thead>
                        <tr>
                            <th>Location</th>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>NG Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ng_data_pic as $key => $value): ?>
                            <?php
                            $options = [
                                'title' => 'Detail Information',
                                'class' => 'popupModal',
                            ];
                            $url = ['pic-ng-detail', 'nik' => $value->emp_id, 'from_date' => $model->from_date, 'to_date' => $model->to_date, 'loc_id' => $value->loc_id];
                            ?>
                            <tr style="font-size: 0.84em;">
                                <td><?= $wip_location_arr[$value->loc_id]; ?></td>
                                <td><?= Html::a($value->emp_id, $url, $options); ?></td>
                                <td><?= $value->emp_name; ?></td>
                                <td><?= $value->sunfishEmp->employ_code; ?></td>
                                <td><?= number_format($value->ng_total); ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Detail Information</h3>',
        'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();
?>