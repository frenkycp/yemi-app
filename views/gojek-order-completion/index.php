<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'ORDER PROGRESS MONITOR <span class="japanesse text-green"> (配達進捗モニター）</span> | GO-WIP',
    'tab_title' => 'ORDER PROGRESS MONITOR',
    'breadcrumbs_title' => 'ORDER PROGRESS MONITOR'
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
print_r($fix_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['index']),
]); ?>

<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'period')->textInput([
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Last Update : <?= date('Y-m-d H:i:s'); ?></h3>
    </div>
    <div class="box-body">
        <div class="box-group" id="accordion">
        <?php
        foreach ($fix_data as $key => $value) {
            /*$karyawan_aktif = app\models\Karyawan::find()->where([
                'NIK' => strval($key),
                //'TANGGAL' => date('Y-m-d')
            ])->one();*/
            $last_update = date('Y-m-d H:i:s', strtotime($value['last_update']));
            if ($value['last_stage'] == 'DEPARTURE') {
                $panel_class = ' box-success';
                $text_status = '<b><u>Departed</u></b> from <u>' . $value['from_loc'] . '</u> to <u>' . $value['to_loc'] . '</u> at <b>' . $last_update . '</b>';
            } elseif ($value['last_stage'] == 'ARRIVAL'){
                $panel_class = ' box-warning';
                $text_status = '<b><u>Arrived</u></b> on <u>' . $value['to_loc'] . '</u> at <b>' . $last_update . '</b>';
                $now = date('Y-m-d H:i:s');
                $diff_time = strtotime($now) - strtotime($last_update);
                $limit_minutes = 15;
                if ($diff_time > ($limit_minutes * 60)) {
                    $panel_class = ' box-danger';
                    $text_status = '<b><u>Idling</u></b> > 15 minutes (Since <b>' . $last_update . '</b>)';
                }
            } else {
                $panel_class = ' box-danger';
                $text_status = '<b><u>No Order</u></b>';
            }
            //$panel_class = ' box-primary';

            if ($value['hadir'] == 'N') {
                $panel_class = ' box-default';
                $text_status = 'INACTIVE';
            }

            foreach ($tmp_sunfish_emp as $tmp_val) {
                if ($tmp_val->Emp_no == $key && $tmp_val->status == 0) {
                    $panel_class = ' box-default';
                    $text_status = 'END CONTRACT';
                }
            }
            /*if (($karyawan_aktif->KONTRAK_KE == 1 && $karyawan_aktif->K1_END < date('Y-m-d')) || $karyawan_aktif->KONTRAK_KE == 2 && $karyawan_aktif->K2_END < date('Y-m-d')) {
                $panel_class = ' box-default';
                $text_status = 'END CONTRACT';
            }*/
            ?>
            <div class="panel box box-solid<?= $panel_class; ?>">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key; ?>">
                            <?= $key . ' - ' . $value['nama'] . ' (' . $karyawan_aktif->SECTION . ') | '; ?>
                        </a>
                        <small style="color: white;">
                            <b><?= $value['todays_point'] > 1 ? $value['todays_point'] . '</b> points' : $value['todays_point'] . '</b> point'; ?>
                        </small>
                    </h4>
                    <div class="pull-right" style="font-size: 12px;">
                        <?= ($text_status); ?>
                    </div>
                </div>
                <div id="collapse<?= $key; ?>" class="panel-collapse collapse<?= \Yii::$app->user->identity->username == $key ? ' in' : '' ?>">
                    <div class="box-body">
                        <?php
                        echo Highcharts::widget([
                            'scripts' => [
                                //'modules/exporting',
                                'themes/grid-light',
                            ],
                            'options' => [
                                'chart' => [
                                    'type' => 'column',
                                ],
                                'credits' => [
                                    'enabled' =>false
                                ],
                                'title' => [
                                    'text' => null
                                ],
                                'xAxis' => [
                                    'type' => 'datetime',
                                    'offset' => 10,
                                ],
                                'yAxis' => [
                                    'title' => [
                                        'text' => 'Total Order'
                                    ],
                                    //'max' => $max_order,
                                    'minTickInterval' => 1,
                                    'stackLabels' => [
                                        'enabled' => true,
                                        'style' => [
                                            'color' => 'red'
                                        ],
                                    ],
                                ],
                                'tooltip' => [
                                    //'shared' => true,
                                    'crosshairs' => true,
                                    'xDateFormat' => '%Y-%m-%d',
                                ],
                                'plotOptions' => [
                                    'column' => [
                                        'stacking' => 'normal',
                                        'dataLabels' => [
                                            'enabled' => true,
                                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                            'style' => [
                                                'fontSize' => '14px',
                                                'fontWeight' => '0'
                                            ],
                                        ],
                                        'borderWidth' => 1,
                                        //'borderColor' => $color,
                                    ],
                                    'series' => [
                                        'cursor' => 'pointer',
                                        'point' => [
                                            'events' => [
                                                'click' => new JsExpression("
                                                    function(e){
                                                        e.preventDefault();
                                                        $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                                    }
                                                "),
                                            ]
                                        ],
                                        'maxPointWidth' => 80,
                                    ]
                                ],
                                'series' => $value['data']
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
            <?php
        }

        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();

        ?>
        </div>
    </div>
</div>

<!--<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h4>
    </div>
    <div class="box-body">
        <?php
        echo ''; Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => null
                ],
                'xAxis' => [
                    'categories' => $categories,
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Total Order'
                    ],
                    //'max' => $max_order,
                    'minTickInterval' => 1,
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            'color' => 'red'
                        ],
                    ],
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                            'style' => [
                                'fontSize' => '14px',
                                'fontWeight' => '0'
                            ],
                        ],
                        'borderWidth' => 1,
                        //'borderColor' => $color,
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('
                                    function(){
                                        $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                    }
                                '),
                            ]
                        ]
                    ]
                ],
                'series' => $data
            ],
        ]);
        
        ?>
    </div>
</div>-->