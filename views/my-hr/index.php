<?php
use yii\helpers\Html;
use app\models\SplView;

/* @var $this yii\web\View */

$this->title = 'My HR';

$this->registerJs("$(function() {
   $('.popup_btn').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
});");
?>

<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <?= Html::img(["uploads/".Yii::$app->user->identity->photo_url], ["class"=>"profile-user-img img-responsive img-circle"]) ?>

                <h3 class="profile-username text-center" style="font-size: 16px;"><?= $model_karyawan->NAMA_KARYAWAN ?></h3>

                <p class="text-muted text-center" style="font-size: 12px;"><?= $model_karyawan->SECTION ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item" style="display: none;">
                        <b>Sisa Cuti</b> <a class="pull-right">?</a>
                    </li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Tentang Saya</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-map-marker margin-r-5"></i> ALAMAT</strong>

                <p class="text-muted"><?= $model_karyawan->ALAMAT ?></p>

                <hr>

                <strong><i class="fa fa-fw fa-calendar"></i> JOIN DATE</strong>

                <p class="text-muted"><?= date('d F Y', strtotime($model_karyawan->TGL_MASUK_YEMI)) ?></p>

                <hr>

                <strong><i class="fa fa-fw fa-star"></i> GRADE</strong>

                <p class="text-muted"><?= $model_karyawan->GRADE ?></p>

            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#absensi" data-toggle="tab">Absensi & Lembur</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane table-responsive" id="absensi">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Period</th>
                                <th style="text-align: center;">Alpha</th>
                                <th style="text-align: center;">Ijin</th>
                                <th style="text-align: center;">Sakit</th>
                                <th style="text-align: center;">Cuti</th>
                                <th style="text-align: center;">Disiplin</th>
                                <th style="text-align: center;">Lembur (jam)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
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
                                $disiplin_icon = '<i class="fa fa-thumbs-up text-green"></i>';
                                if ($value->DISIPLIN == 0) {
                                    $disiplin_icon = Html::a('<i class="fa fa-thumbs-down text-red"></i>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD], ['class' => 'popup_btn']);
                                }

                                $bg_alpha = '';
                                if ($value->ALPHA > 0) {
                                    $bg_alpha = 'badge bg-yellow';
                                }

                                $bg_ijin = '';
                                if ($value->IJIN > 0) {
                                    $bg_ijin = 'badge bg-yellow';
                                }

                                $bg_sakit = '';
                                if ($value->SAKIT > 0) {
                                    $bg_sakit = 'badge bg-yellow';
                                }

                                $bg_cuti = '';
                                if ($value->CUTI > 0) {
                                    $bg_cuti = 'badge bg-yellow';
                                }

                                $total_lembur = $data_lembur->NILAI_LEMBUR_ACTUAL !== null ? $data_lembur->NILAI_LEMBUR_ACTUAL : '-';

                                if ($total_lembur != '-') {
                                    $total_lembur = Html::a('<span class="badge bg-green">' . $data_lembur->NILAI_LEMBUR_ACTUAL . '</span>', ['get-lembur-detail','nik'=>$value->NIK, 'period' => $value->PERIOD], ['class' => 'popup_btn']);
                                }

                                $alpha_val = '-';
                                if ($value->ALPHA > 0) {
                                    $alpha_val = Html::a('<span class="badge bg-yellow">' . $value->ALPHA . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'category' => 'ALPHA'], ['class' => 'popup_btn']);
                                }

                                $ijin_val = '-';
                                if ($value->IJIN > 0) {
                                    $ijin_val = Html::a('<span class="badge bg-yellow">' . $value->IJIN . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'category' => 'IJIN'], ['class' => 'popup_btn']);
                                }

                                $sakit_val = '-';
                                if ($value->SAKIT) {
                                    $sakit_val = Html::a('<span class="badge bg-yellow">' . $value->SAKIT . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'category' => 'SAKIT'], ['class' => 'popup_btn']);
                                }

                                $cuti_val = '-';
                                if ($value->CUTI > 0) {
                                    $cuti_val = Html::a('<span class="badge bg-yellow">' . $value->CUTI . '</span>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD, 'category' => 'CUTI'], ['class' => 'popup_btn']);
                                }
                                
                                echo '<tr>';
                                echo '<td style="text-align: center;">' . $value->PERIOD . '</td>';
                                echo '<td style="text-align: center;">' . $alpha_val . '</td>';
                                echo '<td style="text-align: center;">' . $ijin_val . '</td>';
                                echo '<td style="text-align: center;">' . $sakit_val . '</td>';
                                echo '<td style="text-align: center;">' . $cuti_val . '</td>';
                                echo '<td style="text-align: center;">' . $disiplin_icon . '</td>';
                                echo '<td style="text-align: center;">' . $total_lembur . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
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