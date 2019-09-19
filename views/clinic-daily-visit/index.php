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
    'page_title' => 'CLINIC MONTHLY VISITOR <span class="japanesse text-green"></span>',
    'tab_title' => 'CLINIC MONTHLY VISITOR',
    'breadcrumbs_title' => 'CLINIC MONTHLY VISITOR'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

/*$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );*/

/*echo '<pre>';
print_r($emp_multi_visit_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['clinic-daily-visit/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Year'); ?>
        <?= Html::dropDownList('year', $year, \Yii::$app->params['year_arr'], [
            'class' => 'form-control',
            //'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
    <div class="col-md-2">
        <?= Html::label('Month'); ?>
        <?= Html::dropDownList('month', $month, [
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
        ], [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<h3>Last Update : <?= date('Y-m-d H:i'); ?></h3>
<div class="box-group" id="accordion">

    <div class="panel box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    FREKUENSI KUNJUNGAN V.S JUMLAH KARYAWAN
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="box-body">
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
                        ],
                        'title' => [
                            'text' => null
                        ],
                        'subtitle' => [
                            'text' => ''
                        ],
                        'xAxis' => [
                            //'type' => 'datetime',
                            'categories' => $section_categories,
                        ],
                        'yAxis' => [
                            [
                                'labels' => [
                                    'format' => '{value}%',
                                    'style' => [
                                        //'color' => Highcharts.getOptions().colors[2]
                                    ]
                                ],
                                'title' => [
                                    'text' => 'Presentase Kunjungan',
                                    'style' => [
                                        //'color' => Highcharts.getOptions().colors[2]
                                    ]
                                ],
                                'opposite' => true
                            ],
                            [
                                'labels' => [
                                    //'format' => '{value}%',
                                    'style' => [
                                        //'color' => Highcharts.getOptions().colors[2]
                                    ]
                                ],
                                'title' => [
                                    'text' => 'Jumlah Karyawan',
                                    'style' => [
                                        //'color' => Highcharts.getOptions().colors[2]
                                    ]
                                ],
                            ],
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'tooltip' => [
                            'shared' => true,
                        ],
                        'plotOptions' => [
                            'column' => [
                                'stacking' => 'normal',
                                'dataLabels' => [
                                    'enabled' => false,
                                ],
                            ],
                            'series' => [
                                /*'cursor' => 'pointer',
                                'point' => [
                                    'events' => [
                                        'click' => new JsExpression("
                                            function(e){
                                                e.preventDefault();
                                                $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                            }
                                        "),
                                    ]
                                ]*/
                            ]
                        ],
                        'series' => $data_by_section
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>

    <div class="panel box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseKunjunganBySection">
                    FREKUENSI KUNJUNGAN BY SECTION
                </a>
            </h4>
        </div>
        <div id="collapseKunjunganBySection" class="panel-collapse collapse">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    KARYAWAN > 1X
                                </h3>
                            </div>
                            <div class="box-body no-padding">
                                <table class="table table-responsive table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th>NAMA</th>
                                            <th>DEPARTEMEN</th>
                                            <th>SECTION</th>
                                            <th class="text-center">KUNJUNGAN</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 10px;">
                                        <?php
                                        if (count($emp_multi_visit_data) == 0) {
                                            echo '<tr>
                                                <td colspan=4></td>
                                            </tr>';
                                        }
                                        foreach ($emp_multi_visit_data as $key => $value) {
                                            ?>
                                            <tr>
                                                <td><?= $value['nama']; ?></td>
                                                <td><?= $value['dept']; ?></td>
                                                <td><?= $value['sect']; ?></td>
                                                <td class="text-center"><?= $value['total_kunjungan']; ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php
                        echo Highcharts::widget([
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
                                    'plotShadow' => false
                                ],
                                'title' => [
                                    'text' => null
                                ],
                                'credits' => [
                                    'enabled' =>false
                                ],
                                'tooltip' => [
                                    'pointFormat' => '{series.name}: <b>{point.percentage:.0f}%</b>',
                                ],
                                'plotOptions' => [
                                    'pie' => [
                                        'allowPointSelect' => true,
                                        'cursor' => 'pointer',
                                        'dataLabels' => [
                                            'enabled' => true,
                                            'format' => '<b>{point.name}</b>: {point.percentage:.0f} %'
                                        ],
                                    ],
                                ],
                                'series' => $data_freq_kunjungan
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="panel box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    PEMERIKSAAN
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
            <div class="box-body">
                <div class="box box-primary box-solid">
                    <div class="box-body">
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
                                    'height' => 300
                                ],
                                'title' => [
                                    'text' => 'Diagnosa'
                                ],
                                'xAxis' => [
                                    'categories' => $checkup_by_diagnose['categories']
                                ],
                                'yAxis' => [
                                    'title' => [
                                        'text' => 'Jumlah Karyawan'
                                    ],
                                ],
                                'credits' => [
                                    'enabled' =>false
                                ],
                                'tooltip' => [
                                    'enabled' => false
                                ],
                                'plotOptions' => [
                                    'column' => [
                                        'dataLabels' => [
                                            'enabled' =>true
                                        ],
                                        'maxPointWidth' => 50
                                    ],
                                ],
                                'series' => $checkup_by_diagnose['data']
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="box box-primary box-solid">
                    <div class="box-body">
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
                                    'height' => 300
                                ],
                                'title' => [
                                    'text' => 'Penyebab'
                                ],
                                'xAxis' => [
                                    'categories' => $checkup_by_root_cause['categories']
                                ],
                                'yAxis' => [
                                    'title' => [
                                        'text' => 'Jumlah Karyawan'
                                    ],
                                ],
                                'credits' => [
                                    'enabled' =>false
                                ],
                                'tooltip' => [
                                    'enabled' => false
                                ],
                                'plotOptions' => [
                                    'column' => [
                                        'dataLabels' => [
                                            'enabled' =>true
                                        ],
                                        'maxPointWidth' => 50
                                    ],
                                ],
                                'series' => $checkup_by_root_cause['data']
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                    ISTIRAHAT SAKIT (MAX 1 JAM)
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="box-body">
                <div class="box box-primary box-solid">
                    <div class="box-body">
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
                                    'height' => 300
                                ],
                                'title' => [
                                    'text' => 'Diagnosa'
                                ],
                                'xAxis' => [
                                    'categories' => $rest_by_diagnose['categories']
                                ],
                                'yAxis' => [
                                    'title' => [
                                        'text' => 'Jumlah Karyawan'
                                    ],
                                ],
                                'credits' => [
                                    'enabled' =>false
                                ],
                                'tooltip' => [
                                    'enabled' => false
                                ],
                                'plotOptions' => [
                                    'column' => [
                                        'dataLabels' => [
                                            'enabled' =>true
                                        ],
                                        'maxPointWidth' => 50
                                    ],
                                ],
                                'series' => $rest_by_diagnose['data']
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="box box-primary box-solid">
                    <div class="box-body">
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
                                    'height' => 300
                                ],
                                'title' => [
                                    'text' => 'Penyebab'
                                ],
                                'xAxis' => [
                                    'categories' => $rest_by_root_cause['categories']
                                ],
                                'yAxis' => [
                                    'title' => [
                                        'text' => 'Jumlah Karyawan'
                                    ],
                                ],
                                'credits' => [
                                    'enabled' =>false
                                ],
                                'tooltip' => [
                                    'enabled' => false
                                ],
                                'plotOptions' => [
                                    'column' => [
                                        'dataLabels' => [
                                            'enabled' =>true
                                        ],
                                        'maxPointWidth' => 50
                                    ],
                                ],
                                'series' => $rest_by_root_cause['data']
                            ],
                        ]);
                        ?>
                    </div>
                </div>
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