<?php
use yii\helpers\Html;
use app\models\SplView;

/* @var $this yii\web\View */

$this->title = 'My HR';

$this->registerJs("$(function() {
   $('.popup_btn').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

$this->registerCss('
    .content-header {
        display: none;
    }
');

$profpic = "";
/*if ($model_karyawan !== null && $model_karyawan->JENIS_KELAMIN == 'P') {
    $profpic = 'profile-picture-woman.png';
}*/
?>
<div class="row">
    
</div>


<div class="box box-info box-solid">
    <div class="box-header with-border">
        <h1 class="box-title" style="font-size: 32px; padding-left: 12px;">Papan Informasi</h1>
        <div class="pull-right">
            <?= Html::a('Change Password', ['change-password', 'nik' => $model_karyawan->NIK], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Log Out', ['logout'], ['class' => 'btn btn-danger']) ?>
        </div>
    </div>
    <div class="box-body">
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
                                <b>Sisa Cuti</b> <a class="pull-right badge bg-red"><b><?= $sisa_cuti; ?></b> / <?= $kuota_cuti; ?></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tentang Saya</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Departemen</strong>

                        <p class="text-muted"><?= $model_karyawan->DEPARTEMEN; ?></p>

                        <br\>

                        <strong><i class="fa fa-map-marker margin-r-5"></i> Section</strong>

                        <p class="text-muted"><?= $model_karyawan->SECTION; ?></p>

                        <br\>

                        <strong><i class="fa fa-map-marker margin-r-5"></i> Sub - Section</strong>

                        <p class="text-muted"><?= $model_karyawan->SUB_SECTION; ?></p>

                        <br\>

                        <strong><i class="fa fa-fw fa-calendar"></i> Tanggal Bergabung</strong>

                        <p class="text-muted"><?= $model_karyawan->TGL_MASUK_YEMI !== null ? date('d F Y', strtotime($model_karyawan->TGL_MASUK_YEMI)) : '-'; ?></p>

                        <br\>

                        <strong><i class="fa fa-fw fa-star"></i> Tingkatan</strong>

                        <p class="text-muted"><?= $model_karyawan->GRADE !== null ? $model_karyawan->GRADE : '-'; ?></p>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Absensi & Lembur</h1>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 100px;">Period</th>
                                    <th style="text-align: center; width: 100px;">Alpha</th>
                                    <th style="text-align: center; width: 100px;">Ijin</th>
                                    <th style="text-align: center; width: 100px;">Sakit</th>
                                    <th style="text-align: center; width: 100px;">Datang Terlambat</th>
                                    <th style="text-align: center; width: 100px;">Pulang Cepat</th>
                                    <th style="text-align: center; width: 100px;">Cuti</th>
                                    <th style="text-align: center; width: 100px;">Disiplin</th>
                                    <th style="text-align: center; width: 100px;">Lembur (jam)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_alpa = $total_ijin = $total_sakit = $total_dl = $total_pc = $total_cuti = $grand_total_lembur = 0;
                                foreach ($model_rekap_absensi as $value) {
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
                                    if ($value->DISIPLIN == 0) {
                                        $disiplin_icon = Html::a('<i class="fa fa-close text-red"></i>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD], ['class' => 'popup_btn']);
                                    }

                                    $total_lembur = $data_lembur->NILAI_LEMBUR_ACTUAL !== null && $data_lembur->NILAI_LEMBUR_ACTUAL > 0 ? $data_lembur->NILAI_LEMBUR_ACTUAL : '-';

                                    if ($total_lembur != '-') {
                                        $total_lembur = Html::a('<span class="badge bg-green">' . $data_lembur->NILAI_LEMBUR_ACTUAL . '</span>', ['get-lembur-detail','nik'=>$value->NIK, 'period' => $value->PERIOD], ['class' => 'popup_btn']);
                                        $grand_total_lembur += $data_lembur->NILAI_LEMBUR_ACTUAL;
                                    }

                                    $alpha_val = '-';
                                    if ($value->ALPHA > 0) {
                                        $alpha_val = Html::a('<span class="badge bg-yellow">' . $value->ALPHA . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'note' => 'A'], ['class' => 'popup_btn']);
                                        $total_alpa += $value->ALPHA;
                                    }

                                    $ijin_val = '-';
                                    if ($value->IJIN > 0) {
                                        $ijin_val = Html::a('<span class="badge bg-yellow">' . $value->IJIN . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'note' => 'I'], ['class' => 'popup_btn']);
                                        $total_ijin += $value->IJIN;
                                    }

                                    $sakit_val = '-';
                                    if ($value->SAKIT > 0) {
                                        $sakit_val = Html::a('<span class="badge bg-yellow">' . $value->SAKIT . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'note' => 'S'], ['class' => 'popup_btn']);
                                        $total_sakit += $value->SAKIT;
                                    }

                                    $dl_val = '-';
                                    if ($value->DATANG_TERLAMBAT > 0) {
                                        $dl_val = Html::a('<span class="badge bg-yellow">' . $value->DATANG_TERLAMBAT . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'note' => 'DL'], ['class' => 'popup_btn']);
                                        $total_dl += $value->DATANG_TERLAMBAT;
                                    }

                                    $pc_val = '-';
                                    if ($value->PULANG_CEPAT > 0) {
                                        $pc_val = Html::a('<span class="badge bg-yellow">' . $value->PULANG_CEPAT . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'note' => 'PC'], ['class' => 'popup_btn']);
                                        $total_pc += $value->PULANG_CEPAT;
                                    }

                                    $cuti_val = '-';
                                    if ($value->CUTI > 0) {
                                        $cuti_val = Html::a('<span class="badge bg-yellow">' . $value->CUTI . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'note' => 'C'], ['class' => 'popup_btn']);
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
                                    echo '</tr>';
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
                                echo '<td style="text-align: center;"><span class="badge">' . $grand_total_lembur . '</span></td>';
                                echo '</tr>';

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <h4 style="<?= $model_karyawan !== null ? 'display: none;' : ''; ?>">Please insert registered NIK ...</h4>
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