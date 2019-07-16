<?php
use yii\helpers\Html;
use app\models\SplView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

/* @var $this yii\web\View */

$this->title = 'My HR';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("$(function() {
   $('.popup_btn').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

$this->registerCss('
    .content-header {
        display: none;
    }
');

$profpic = "";
/*echo '<pre>';
print_r($data);
echo '</pre>';*/
/*if ($model_karyawan !== null && $model_karyawan->JENIS_KELAMIN == 'P') {
    $profpic = 'profile-picture-woman.png';
}*/
?>

<div class="row" style="<?= $model_karyawan === null ? 'display: none;' : ''; ?>">
    <div class="col-md-3">
        <div class="box box-primary box-solid">
            <div class="box-body box-profile">
                <?php
                $filename = $model_karyawan->NIK . '.jpg';
                $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                if (file_exists($path)) {
                    echo Html::img('@web/uploads/yemi_employee_img/' . $model_karyawan->NIK . '.jpg', [
                        'class' => 'profile-user-img img-responsive img-circle',
                        'style' => 'object-fit: cover; height: 120px; width: 120px;'
                    ]);
                } else {
                    echo Html::img('@web/uploads/profpic_02.png', [
                        'class' => 'profile-user-img img-responsive img-circle',
                        'style' => 'object-fit: cover; height: 120px; width: 120px;'
                    ]);
                }
                ?>

                <h3 class="profile-username text-center" style="font-size: 16px;"><?= $model_karyawan->NAMA_KARYAWAN ?></h3>

                <p class="text-muted text-center" style="font-size: 14px;"><?= $model_karyawan->NIK; ?></p>

                <ul class="list-group list-group-unbordered" style="">
                    <li class="list-group-item">
                        <b>Personal Leave</b> <a class="pull-right badge bg-red"><b><?= $sisa_cuti; ?></b> / <?= $kuota_cuti; ?></a>
                    </li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-map-marker margin-r-5"></i> Department</strong>

                <p class="text-muted"><?= $model_karyawan->DEPARTEMEN; ?></p>

                <br\>

                <strong><i class="fa fa-map-marker margin-r-5"></i> Section</strong>

                <p class="text-muted"><?= $model_karyawan->SECTION; ?></p>

                <br\>

                <strong><i class="fa fa-map-marker margin-r-5"></i> Sub - Section</strong>

                <p class="text-muted"><?= $model_karyawan->SUB_SECTION; ?></p>

                <br\>

                <strong><i class="fa fa-fw fa-calendar"></i> Join Date</strong>

                <p class="text-muted"><?= $model_karyawan->TGL_MASUK_YEMI !== null ? date('d F Y', strtotime($model_karyawan->TGL_MASUK_YEMI)) : '-'; ?></p>

                <br\>

                <strong><i class="fa fa-fw fa-star"></i> Grade</strong>

                <p class="text-muted"><?= $model_karyawan->GRADE !== null ? $model_karyawan->GRADE : '-'; ?></p>

                <br\>

                <strong><i class="fa fa-fw fa-star"></i> Marriage Status</strong>

                <p class="text-muted"><?= $model_karyawan->STATUS_PERKAWINAN !== null ? $model_karyawan->STATUS_PERKAWINAN : '-'; ?></p>

            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-9">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Attendance and Overtime</h1>
            </div>
            <div class="box-body">

                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'layout' => 'horizontal',
                    'action' => Url::to(['my-hr/index']),
                ]); ?>
                <div class="row">
                    <div class="col-md-2 col-md-offset-10">
                        <?= Html::dropDownList('year', $year, \Yii::$app->params['year_arr'], [
                            'class' => 'form-control',
                            'onchange'=>'this.form.submit()',
                        ]); ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <br/>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr style="font-size: 12px;">
                            <th style="text-align: center; vertical-align: middle; min-width: 90px;">Period</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Absent</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Permit</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Sick</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Come Late</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Home Early</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Personal Leave</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Disciplinary<br/>Allowance</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Overtime (hour)</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Total<br/>Shift II</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Total<br/>Shift III</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Total<br/>Shift IV</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_alpa = $total_ijin = $total_sakit = $total_dl = $total_pc = $total_cuti = $grand_total_lembur = 0;
                        $grade = substr($model_karyawan->GRADE, 0, 1);
                        foreach ($absensi_data as $value) {
                            $data_lembur = SplView::find()
                            ->select([
                                'PERIOD',
                                'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
                            ])
                            ->where([
                                'NIK' => $value->NIK,
                                'PERIOD' => $value->PERIOD
                            ])
                            ->groupBy('PERIOD')
                            ->one();
                            $disiplin_icon = '<i class="fa fa-circle-o text-green"></i>';
                            if ($value->NO_DISIPLIN > 0 || in_array($grade, ['L', 'M', 'D'])) {
                                $disiplin_icon = Html::a('<i class="fa fa-close text-red"></i>', ['get-disiplin-detail','nik'=>$value->NIK, 'nama_karyawan' => $value->NAMA_KARYAWAN, 'period' => $value->PERIOD], ['class' => 'popup_btn']);
                            }
                            //$disiplin_icon = (int)$value->DISIPLIN;

                            $total_lembur = $data_lembur->NILAI_LEMBUR_ACTUAL !== null && $data_lembur->NILAI_LEMBUR_ACTUAL > 0 ? $data_lembur->NILAI_LEMBUR_ACTUAL : '-';

                            if ($total_lembur != '-') {
                                $total_lembur = Html::a('<span class="badge bg-green">' . $data_lembur->NILAI_LEMBUR_ACTUAL . '</span>', ['get-lembur-detail','nik'=>$value->NIK, 'nama_karyawan' => $value->NAMA_KARYAWAN, 'period' => $value->PERIOD], ['class' => 'popup_btn']);
                                $grand_total_lembur += $data_lembur->NILAI_LEMBUR_ACTUAL;
                            }

                            $alpha_val = '-';
                            if ($value->ALPHA > 0) {
                                $alpha_val = Html::a('<span class="badge bg-yellow">' . $value->ALPHA . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'nama_karyawan' => $value->NAMA_KARYAWAN, 'period' => $value->PERIOD, 'note' => 'A'], ['class' => 'popup_btn']);
                                $total_alpa += $value->ALPHA;
                            }

                            $ijin_val = '-';
                            if ($value->IJIN > 0) {
                                $ijin_val = Html::a('<span class="badge bg-yellow">' . $value->IJIN . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'nama_karyawan' => $value->NAMA_KARYAWAN, 'period' => $value->PERIOD, 'note' => 'I'], ['class' => 'popup_btn']);
                                $total_ijin += $value->IJIN;
                            }

                            $sakit_val = '-';
                            if ($value->SAKIT > 0) {
                                $sakit_val = Html::a('<span class="badge bg-yellow">' . $value->SAKIT . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'nama_karyawan' => $value->NAMA_KARYAWAN, 'period' => $value->PERIOD, 'note' => 'S'], ['class' => 'popup_btn']);
                                $total_sakit += $value->SAKIT;
                            }

                            $dl_val = '-';
                            if ($value->DATANG_TERLAMBAT > 0) {
                                $dl_val = Html::a('<span class="badge bg-yellow">' . $value->DATANG_TERLAMBAT . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'nama_karyawan' => $value->NAMA_KARYAWAN, 'period' => $value->PERIOD, 'note' => 'DL'], ['class' => 'popup_btn']);
                                $total_dl += $value->DATANG_TERLAMBAT;
                            }

                            $pc_val = '-';
                            if ($value->PULANG_CEPAT > 0) {
                                $pc_val = Html::a('<span class="badge bg-yellow">' . $value->PULANG_CEPAT . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'nama_karyawan' => $value->NAMA_KARYAWAN, 'period' => $value->PERIOD, 'note' => 'PC'], ['class' => 'popup_btn']);
                                $total_pc += $value->PULANG_CEPAT;
                            }

                            $cuti_val = '-';
                            if ($value->CUTI > 0) {
                                $cuti_val = Html::a('<span class="badge bg-yellow">' . $value->CUTI . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'nama_karyawan' => $value->NAMA_KARYAWAN, 'period' => $value->PERIOD, 'note' => 'C'], ['class' => 'popup_btn']);
                                $total_cuti += $value->CUTI;
                            }

                            $period = date('M\' Y', strtotime($value->PERIOD . '01'));
                            
                            echo '<tr>';
                            echo '<td style="text-align: center;">' . $period . '</td>';
                            echo '<td style="text-align: center;">' . $alpha_val . '</td>';
                            echo '<td style="text-align: center;">' . $ijin_val . '</td>';
                            echo '<td style="text-align: center;">' . $sakit_val . '</td>';
                            echo '<td style="text-align: center;">' . $dl_val . '</td>';
                            echo '<td style="text-align: center;">' . $pc_val . '</td>';
                            echo '<td style="text-align: center;">' . $cuti_val . '</td>';
                            echo '<td style="text-align: center;">' . $disiplin_icon . '</td>';
                            echo '<td style="text-align: center;">' . $total_lembur . '</td>';
                            echo '<td style="text-align: center;">' . $value->SHIFT2 . '</td>';
                            echo '<td style="text-align: center;">' . $value->SHIFT3 . '</td>';
                            echo '<td style="text-align: center;">' . $value->SHIFT4 . '</td>';
                            echo '</tr>';
                        }

                        $lembur_str = '-';
                        if ($grand_total_lembur > 0) {
                            $lembur_str = $grand_total_lembur;
                        }

                        echo '<tr class="info" style="font-weight: bold;">';
                        echo '<td style="text-align: center;">Total :</td>';
                        echo '<td style="text-align: center;"><span class="badge">' . $total_alpa . '</span></td>';
                        echo '<td style="text-align: center;"><span class="badge">' . $total_ijin . '</span></td>';
                        echo '<td style="text-align: center;"><span class="badge">' . $total_sakit . '</span></td>';
                        echo '<td style="text-align: center;"><span class="badge">' . $total_dl . '</span></td>';
                        echo '<td style="text-align: center;"><span class="badge">' . $total_pc . '</span></td>';
                        echo '<td style="text-align: center;"><span class="badge">' . $total_cuti . '</span></td>';
                        echo '<td style="text-align: center;"></td>';
                        echo '<td style="text-align: center;"><span class="badge">' . $lembur_str . '</span></td>';
                        echo '<td style="text-align: center;"></td>';
                        echo '<td style="text-align: center;"></td>';
                        echo '<td style="text-align: center;"></td>';
                        echo '</tr>';

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user"></i> <?= 'OT Management by Section (' . $section . ')' ?></h3>
            </div>
            <div class="box-body">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        //'modules/exporting',
                        'themes/grid-light',
                        //'themes/dark-unica',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'spline',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'zoomType' => 'x',
                            //'height' => 290
                        ],
                        'credits' => [
                            'enabled' => false
                        ],
                        'title' => [
                            'text' => null,
                        ],
                        'subtitle' => [
                            'text' => '',
                        ],
                        'xAxis' => [
                            'categories' => $categories,

                        ],
                        'yAxis' => [
                            'title' => [
                                'text' => 'HOURS'
                            ],
                            'min' => 0,
                            'max' => 100,
                            'plotLines' => [
                                [
                                    'value' => 10,
                                    'color' => 'orange',
                                    'dashStyle' => 'shortdash',
                                    'width' => 2,
                                    'label' => [
                                        'text' => 'NORMAL (10)',
                                        'align' => 'left',
                                    ],
                                    //'zIndex' => 5
                                ], [
                                    'value' => 20,
                                    'color' => 'red',
                                    'dashStyle' => 'shortdash',
                                    'width' => 2,
                                    'label' => [
                                        'text' => 'MAXIMUM (20)',
                                        'align' => 'left',
                                    ],
                                    //'zIndex' => 5
                                ]
                            ]
                        ],
                        'plotOptions' => [
                            'spline' => [
                                'dataLabels' => [
                                    'enabled' => true,
                                ],
                            ],
                            'series' => [
                                'cursor' => 'pointer',
                                'marker' => [
                                    'enabled' => false
                                ],
                                'dataLabels' => [
                                    //'allowOverlap' => true
                                    //'enabled' => true
                                ],
                                /*'point' => [
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
                        'series' => $data,
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>


<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Detail Info</h3>',
        'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();
?>