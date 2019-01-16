<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/
$copyParams = $model->attributes;

$this->title = [
    'page_title' => '',
    'tab_title' => 'Detail Data',
    'breadcrumbs_title' => 'Detail Data'
];

$this->registerJs("$(function() {
   $('.popup_btn').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $nik . ' - ' . $nama_karyawan; ?></h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="text-align: center; width: 100px;">Period</th>
                    <th style="text-align: center; width: 100px;">Absent</th>
                    <th style="text-align: center; width: 100px;">Permit</th>
                    <th style="text-align: center; width: 100px;">Sick</th>
                    <th style="text-align: center; width: 100px;">Come Late</th>
                    <th style="text-align: center; width: 100px;">Home Early</th>
                    <th style="text-align: center; width: 100px;">Personal Leave</th>
                    <th style="text-align: center; width: 100px;">Disciplinary<br/>Allowance</th>
                    <th style="text-align: center; width: 100px;">Overtime (hour)</th>
                </tr>
            </thead>
            <tbody style="font-size: 12px;">
                <?php
                $total_alpa = $total_ijin = $total_sakit = $total_dl = $total_pc = $total_cuti = $grand_total_lembur = 0;
                foreach ($model_rekap_absensi as $value) {
                    $data_lembur = app\models\SplView::find()
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

<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Detail Info</h3>',
        'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();
?>