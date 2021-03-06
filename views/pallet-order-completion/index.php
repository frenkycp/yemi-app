<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'ORDER PROGRESS MONITOR <span class="japanesse text-green">(配達進捗モニター）</span> | GO-PALLET',
    'tab_title' => 'ORDER PROGRESS MONITOR',
    'breadcrumbs_title' => 'ORDER PROGRESS MONITOR'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

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
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['pallet-order-completion/index']),
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
<br/>

<?php ActiveForm::end(); ?>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Last Update : <?= date('Y-m-d H:i:s'); ?></h3>
    </div>
    <div class="box-body">
        <div class="box-group" id="accordion">
            <?php
            foreach ($data as $key => $value) {
                $driver_status = $value['driver_status'];
                $text_status = 'New Driver';
                $panel_class = ' box-success';
                if ($driver_status == 1) {
                    $text_status = '<b><u>Picked</u></b> order from Line <b>' . $value['order_from'] . '</b> at <b>' . $value['last_update'] . '</b>';
                } elseif ($driver_status == 2) {
                    $text_status = '<b><u>Finished</u></b> order from Line <b>' . $value['order_from'] . '</b> at <b>' . $value['last_update'] . '</b>';
                    $panel_class = ' box-warning';
                    $now = date('Y-m-d H:i:s');
                    $diff_time = strtotime($now) - strtotime($value['last_update']);
                    $limit_minutes = 2;
                    if ($diff_time > ($limit_minutes * 60)) {
                        $panel_class = ' box-danger';
                        $text_status = '<b><u>Idling</u></b> > ' . $limit_minutes . ' minutes (Since <b>' . $value['last_update'] . '</b>)';
                    }
                }

                /*$karyawan_aktif = app\models\MpInOut::find()->where([
                    'NIK' => strval($key),
                    'TANGGAL' => date('Y-m-d')
                ])->one();*/

                $tmp_karyawan = app\models\Karyawan::find()
                ->where([
                    'OR',
                    ['NIK' => strval($key)],
                    ['NIK_SUN_FISH' => strval($key)]
                ])
                ->one();

                if ($tmp_karyawan->NIK_SUN_FISH == null) {
                    $panel_class = ' box-default';
                    $text_status = 'END CONTRACT';
                } else {
                    $tmp_karyawan2 = app\models\SunfishViewEmp::find()
                    ->where([
                        'Emp_no' => $tmp_karyawan->NIK_SUN_FISH
                    ])
                    ->one();

                    if ($tmp_karyawan2->status == 0 || $tmp_karyawan2->Emp_no == null) {
                        $panel_class = ' box-default';
                        $text_status = 'END CONTRACT';
                    }
                }
                
                ?>
                <div class="panel box box-solid<?= $panel_class; ?>">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key; ?>">
                                <?= $key . ' - ' . $value['nama'] . ' <i>(Factory ' . $value['factory'] . ')</i> | '; ?>
                            </a>
                            <small style="color: white;">
                                <b><?= $value['todays_point'] > 1 ? $value['todays_point'] . '</b> points' : $value['todays_point'] . '</b> point'; ?>
                            </small>
                        </h4>
                        <div class="pull-right" style="font-size: 12px;">
                            <?= $text_status; ?>
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
                                                'enabled' => false,
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