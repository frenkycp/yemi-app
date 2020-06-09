<?php
use yii\helpers\Html;
use app\models\SplView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use app\models\SunfishEmpAttendance;

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
    .badge {font-weight: unset;}
    th, td {vertical-align: middle !important;}
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
                    echo Html::img('@web/uploads/profpic_03.png', [
                        'class' => 'profile-user-img img-responsive img-circle',
                        'style' => 'object-fit: cover; height: 120px; width: 120px;'
                    ]);
                }
                ?>

                <h3 class="profile-username text-center" style="font-size: 16px;"><?= $model_karyawan->NAMA_KARYAWAN ?></h3>

                <p class="text-muted text-center" style="font-size: 14px;"><?= $model_karyawan->NIK_SUN_FISH; ?></p>

                <ul class="list-group list-group-unbordered" style="">
                    <li class="list-group-item">
                        <b>Personal Leave</b> <i>(Balance / Quota)</i> <a class="pull-right badge bg-red"><b><?= $sisa_cuti; ?></b> / <?= $kuota_cuti; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Long Leave</b> <i>(Balance / Quota)</i> <a class="pull-right badge bg-red"><b><?= $sisa_cuti_panjang; ?></b> / <?= $kuota_cuti_panjang; ?></a>
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
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Special Leave</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Disciplinary<br/>Allowance</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Overtime (hour)</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Total<br/>Shift II</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Total<br/>Shift III</th>
                            <th style="text-align: center; vertical-align: middle; width: 100px;">Total<br/>Shift IV</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_alpa = $total_ijin = $total_sakit = $total_dl = $total_pc = $total_cuti = $grand_total_lembur = $total_ck = 0;
                        $grade = substr($model_karyawan->GRADE, 0, 1);
                        foreach ($data_attendance_arr as $value) {
                            // $data_lembur = SplView::find()
                            // ->select([
                            //     'PERIOD',
                            //     'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
                            // ])
                            // ->where([
                            //     'NIK' => $value['emp_no'],
                            //     'PERIOD' => $value['period']
                            // ])
                            // ->groupBy('PERIOD')
                            // ->one();
                            $data_lembur = SunfishEmpAttendance::find()
                            ->select([
                                'total_ot' => 'SUM(total_ot)'
                            ])
                            ->where([
                                'emp_no' => $model_karyawan->NIK_SUN_FISH,
                                'FORMAT(shiftstarttime, \'yyyyMM\')' => $value['period']
                            ])
                            ->one();

                            $disiplin_icon = '<i class="fa fa-circle-o text-green"></i>';
                            if (($value['total_absent'] > 0
                                || $value['total_permit'] > 0
                                || $value['total_sick'] > 0
                                || $value['total_late'] > 0
                                || $value['total_early_out'] > 0
                                || $value['total_ck_no_disiplin'] > 0) || in_array($grade, ['L', 'M', 'D'])) {
                                //$disiplin_icon = Html::a('<i class="fa fa-close text-red"></i>', ['get-disiplin-detail','nik'=>$value['emp_no'], 'nama_karyawan' => $model_karyawan->NAMA_KARYAWAN, 'period' => $value['period']], ['class' => 'popup_btn']);
                                $disiplin_icon = '<i class="fa fa-close text-red"></i>';
                            }
                            //$disiplin_icon = (int)$value['DISIPLIN'];

                            $total_lembur = $data_lembur->total_ot > 0 ? round(($data_lembur->total_ot / 60), 2) : '-';

                            if ($total_lembur != '-') {
                                $total_lembur = Html::a('<span class="badge bg-green">' . $total_lembur . '</span>', ['get-lembur-detail','nik' => $model_karyawan->NIK_SUN_FISH, 'nama_karyawan' => $model_karyawan->NAMA_KARYAWAN, 'period' => $value['period']], ['class' => 'popup_btn']);
                                $grand_total_lembur += round(($data_lembur->total_ot / 60), 2);
                            }

                            $alpha_val = '-';
                            if ($value['total_absent'] > 0) {
                                $alpha_val = Html::a('<span class="badge bg-yellow">' . $value['total_absent'] . '</span>', ['get-disiplin-detail','nik'=>$value['emp_no'], 'nama_karyawan' => $model_karyawan->NAMA_KARYAWAN, 'period' => $value['period'], 'source' => $value['source'], 'note' => 'A'], ['class' => 'popup_btn']);
                                $total_alpa += $value['total_absent'];
                            }

                            $ijin_val = '-';
                            if ($value['total_permit'] > 0) {
                                $ijin_val = Html::a('<span class="badge bg-yellow">' . $value['total_permit'] . '</span>', ['get-disiplin-detail','nik'=>$value['emp_no'], 'nama_karyawan' => $model_karyawan->NAMA_KARYAWAN, 'period' => $value['period'], 'source' => $value['source'], 'note' => 'I'], ['class' => 'popup_btn']);
                                $total_ijin += $value['total_permit'];
                            }

                            $sakit_val = '-';
                            if ($value['total_sick'] > 0) {
                                $sakit_val = Html::a('<span class="badge bg-yellow">' . $value['total_sick'] . '</span>', ['get-disiplin-detail','nik'=>$value['emp_no'], 'nama_karyawan' => $model_karyawan->NAMA_KARYAWAN, 'period' => $value['period'], 'source' => $value['source'], 'note' => 'S'], ['class' => 'popup_btn']);
                                $total_sakit += $value['total_sick'];
                            }

                            $dl_val = '-';
                            if ($value['total_late'] > 0) {
                                $dl_val = Html::a('<span class="badge bg-yellow">' . $value['total_late'] . '</span>', ['get-disiplin-detail','nik'=>$value['emp_no'], 'nama_karyawan' => $model_karyawan->NAMA_KARYAWAN, 'period' => $value['period'], 'source' => $value['source'], 'note' => 'DL'], ['class' => 'popup_btn']);
                                $total_dl += $value['total_late'];
                            }

                            $pc_val = '-';
                            if ($value['total_early_out'] > 0) {
                                $pc_val = Html::a('<span class="badge bg-yellow">' . $value['total_early_out'] . '</span>', ['get-disiplin-detail','nik'=>$value['emp_no'], 'nama_karyawan' => $model_karyawan->NAMA_KARYAWAN, 'period' => $value['period'], 'source' => $value['source'], 'note' => 'PC'], ['class' => 'popup_btn']);
                                $total_pc += $value['total_early_out'];
                            }

                            $cuti_val = '-';
                            if ($value['total_cuti'] > 0) {
                                $cuti_val = Html::a('<span class="badge bg-yellow">' . $value['total_cuti'] . '</span>', ['get-disiplin-detail','nik'=>$value['emp_no'], 'nama_karyawan' => $model_karyawan->NAMA_KARYAWAN, 'period' => $value['period'], 'source' => $value['source'], 'note' => 'C'], ['class' => 'popup_btn']);
                                $total_cuti += $value['total_cuti'];
                            }

                            $ck_val = '-';
                            if ($value['total_ck'] > 0) {
                                $ck_val = Html::a('<span class="badge bg-yellow">' . $value['total_ck'] . '</span>', ['get-disiplin-detail','nik'=>$value['emp_no'], 'nama_karyawan' => $model_karyawan->NAMA_KARYAWAN, 'period' => $value['period'], 'source' => $value['source'], 'note' => 'CK'], ['class' => 'popup_btn']);
                                $total_ck += $value['total_ck'];
                            }

                            $period = date('M\' Y', strtotime($value['period'] . '01'));
                            
                            echo '<tr>';
                            echo '<td style="text-align: center;">' . $period . '</td>';
                            echo '<td style="text-align: center;">' . $alpha_val . '</td>';
                            echo '<td style="text-align: center;">' . $ijin_val . '</td>';
                            echo '<td style="text-align: center;">' . $sakit_val . '</td>';
                            echo '<td style="text-align: center;">' . $dl_val . '</td>';
                            echo '<td style="text-align: center;">' . $pc_val . '</td>';
                            echo '<td style="text-align: center;">' . $cuti_val . '</td>';
                            echo '<td style="text-align: center;">' . $ck_val . '</td>';
                            echo '<td style="text-align: center;">' . $disiplin_icon . '</td>';
                            echo '<td style="text-align: center;">' . $total_lembur . '</td>';
                            echo '<td style="text-align: center;">' . $value['total_shift2'] . '</td>';
                            echo '<td style="text-align: center;">' . $value['total_shift3'] . '</td>';
                            echo '<td style="text-align: center;">' . $value['total_shift4'] . '</td>';
                            echo '</tr>';
                        }

                        $lembur_str = '-';
                        if ($grand_total_lembur > 0) {
                            $lembur_str = $grand_total_lembur;
                        }

                        echo '<tr class="info" style="font-weight: bold;">';
                        echo '<td style="text-align: center;">Total :</td>';
                        echo '<td style="text-align: center;"><span class="">' . $total_alpa . '</span></td>';
                        echo '<td style="text-align: center;"><span class="">' . $total_ijin . '</span></td>';
                        echo '<td style="text-align: center;"><span class="">' . $total_sakit . '</span></td>';
                        echo '<td style="text-align: center;"><span class="">' . $total_dl . '</span></td>';
                        echo '<td style="text-align: center;"><span class="">' . $total_pc . '</span></td>';
                        echo '<td style="text-align: center;"><span class="">' . $total_cuti . '</span></td>';
                        echo '<td style="text-align: center;"><span class="">' . $total_ck . '</span></td>';
                        echo '<td style="text-align: center;"></td>';
                        echo '<td style="text-align: center;"><span class="">' . $lembur_str . '</span></td>';
                        echo '<td style="text-align: center;"></td>';
                        echo '<td style="text-align: center;"></td>';
                        echo '<td style="text-align: center;"></td>';
                        echo '</tr>';

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box box-primary box-solid" style="display: none;">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-user"></i> <?= 'OT Management by Section (' . $section . ')' ?></h3>
            </div>
            <div class="box-body">
                <?php
                // echo Highcharts::widget([
                //     'scripts' => [
                //         'themes/grid-light',
                //     ],
                //     'options' => [
                //         'chart' => [
                //             'type' => 'spline',
                //             'style' => [
                //                 'fontFamily' => 'sans-serif',
                //             ],
                //             'zoomType' => 'x',
                //         ],
                //         'credits' => [
                //             'enabled' => false
                //         ],
                //         'title' => [
                //             'text' => null,
                //         ],
                //         'subtitle' => [
                //             'text' => '',
                //         ],
                //         'xAxis' => [
                //             'categories' => $categories,

                //         ],
                //         'yAxis' => [
                //             'title' => [
                //                 'text' => 'HOURS'
                //             ],
                //             'min' => 0,
                //             'max' => 100,
                //             'plotLines' => [
                //                 [
                //                     'value' => 10,
                //                     'color' => 'orange',
                //                     'dashStyle' => 'shortdash',
                //                     'width' => 2,
                //                     'label' => [
                //                         'text' => 'NORMAL (10)',
                //                         'align' => 'left',
                //                     ],
                //                     //'zIndex' => 5
                //                 ], [
                //                     'value' => 20,
                //                     'color' => 'red',
                //                     'dashStyle' => 'shortdash',
                //                     'width' => 2,
                //                     'label' => [
                //                         'text' => 'MAXIMUM (20)',
                //                         'align' => 'left',
                //                     ],
                //                 ]
                //             ]
                //         ],
                //         'plotOptions' => [
                //             'spline' => [
                //                 'dataLabels' => [
                //                     'enabled' => true,
                //                 ],
                //             ],
                //             'series' => [
                //                 'cursor' => 'pointer',
                //                 'marker' => [
                //                     'enabled' => false
                //                 ],
                //             ]
                //         ],
                //         'series' => $data,
                //     ],
                // ]);
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