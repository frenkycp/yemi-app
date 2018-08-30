<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Dashboard';

$this->registerJs("$(function() {
   $('.popup_disiplin').click(function(e) {
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
                    <li class="list-group-item">
                        <b>Sisa Cuti</b> <a class="pull-right">0</a>
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
                <li class="active"><a href="#absensi" data-toggle="tab">Absensi</a></li>
                <li class=""><a href="#lembur" data-toggle="tab">Lembur</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="absensi">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Period</th>
                                <th style="text-align: center;">Alpha</th>
                                <th style="text-align: center;">Ijin</th>
                                <th style="text-align: center;">Sakit</th>
                                <th style="text-align: center;">Cuti</th>
                                <th style="text-align: center;">Disiplin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($model_rekap_absensi as $value) {
                                $disiplin_icon = '<i class="fa fa-thumbs-up text-green"></i>';
                                if ($value->DISIPLIN == 0) {
                                    $disiplin_icon = Html::a('<i class="fa fa-thumbs-down text-red"></i>', ['get-disiplin-detail','nik'=>$value->NIK, 'period' => $value->PERIOD], ['class' => 'popup_disiplin']);
                                }

                                $bg_alpha = 'bg-green';
                                if ($value->ALPHA > 0) {
                                    $bg_alpha = 'bg-red';
                                }

                                $bg_ijin = 'bg-green';
                                if ($value->IJIN > 0) {
                                    $bg_ijin = 'bg-red';
                                }

                                $bg_sakit = 'bg-green';
                                if ($value->SAKIT > 0) {
                                    $bg_sakit = 'bg-red';
                                }

                                $bg_cuti = 'bg-green';
                                if ($value->CUTI > 0) {
                                    $bg_cuti = 'bg-yellow';
                                }
                                
                                echo '<tr>';
                                echo '<td style="text-align: center;">' . $value->PERIOD . '</td>';
                                echo '<td style="text-align: center;">' . '<span class="badge ' . $bg_alpha . '">' . $value->ALPHA . '</span>' . '</td>';
                                echo '<td style="text-align: center;">' . '<span class="badge ' . $bg_ijin . '">' . $value->IJIN . '</span>' . '</td>';
                                echo '<td style="text-align: center;">' . '<span class="badge ' . $bg_sakit . '">' . $value->SAKIT . '</span>' . '</td>';
                                echo '<td style="text-align: center;">' . '<span class="badge ' . $bg_cuti . '">' . $value->CUTI . '</span>' . '</td>';
                                echo '<td style="text-align: center;">' . $disiplin_icon . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="lembur"></div>
            </div>
        </div>
    </div>
</div>
<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Detail Info</h3>',
        //'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();
?>