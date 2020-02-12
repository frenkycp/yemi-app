<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\db\Expression;

$this->title = [
    'page_title' => 'CLINIC VISITING LIST (<span class="japanesse light-green">クリニック利用者の管理表</span>)',
    'tab_title' => 'CLINIC VISITING LIST',
    'breadcrumbs_title' => 'CLINIC VISITING LIST'
];

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
	.content-header {color: white;}
    .box-body {background-color: #000;}
	.box-title {font-weight: bold;}
	.box-header .box-title, .control-label{font-size: 1.5em;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}

    #clinic-tbl{
        border:1px solid #ddd;
        border-top: 0;
    }
    #clinic-tbl > thead > tr > th{
        font-weight: normal;
        border:1px solid #8b8c8d;
        background-color: #858689;
        color: white;
        font-size: 2.5em;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #clinic-tbl > tbody > tr > td{
        border:1px solid #ddd;
        font-size: 2em;
        background-color: #000;
        //font-weight: 1000;
        color: rgba(255, 235, 59, 1);
        vertical-align: middle;
    }
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px; text-transform: uppercase;}
");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 3600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;

$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['index-update']) . "',
            success: function(data){
                var tmp_data = JSON.parse(data);
                $('#today-visitor').html(tmp_data.today_visitor);
                $('#monthly-visitor').html(tmp_data.monthly_visitor);
                $('#available-beds').html(tmp_data.available_beds);
                $('#doctor-content').html(tmp_data.doctor_content);
                $('#nurse-content').html(tmp_data.nurse_content);
                $('#table-container').html(tmp_data.table_container);
                $('#laktasi-id').html(tmp_data.laktasi);
            },
            complete: function(){
                setTimeout(function(){update_data();}, 3000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
    });
");

$this->registerJs($script, View::POS_END);

date_default_timezone_set('Asia/Jakarta');

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

<div class="row">
    <div class="col-lg-2 col-xs-6 col-md-3">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3 id="today-visitor"><?= $today_visitor; ?></h3>
                <p>Pengunjung Hari Ini</p>
            </div>
            <div class="icon">
                <i class="glyphicon glyphicon-user"></i>
            </div>
            <a class="small-box-footer"></a>
        </div>
    </div>
    <div class="col-lg-2 col-xs-6 col-md-3">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3 id="monthly-visitor"><?= $monthly_visitor; ?></h3>
                <p>Pengunjung Bulan Ini</p>
            </div>
            <div class="icon">
                <i class="glyphicon glyphicon-calendar"></i>
            </div>
            <a class="small-box-footer"></a>
        </div>
    </div>
    <div class="col-lg-2 col-xs-6 col-md-3">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3><span id="available-beds"><?= $available_beds; ?></span></h3>
                <p>Ruangan Tersedia</p>
            </div>
            <div class="icon">
                <i class="glyphicon glyphicon-bed"></i>
            </div>
            <a class="small-box-footer"></a>
        </div>
    </div>
    <div class="col-lg-2 col-xs-6 col-md-3">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3><span id="laktasi-id"><?= $laktasi; ?></span></h3>
                <p>Sedang Laktasi</p>
            </div>
            <div class="icon">
                <i class="glyphicon glyphicon-tint"></i>
            </div>
            <a class="small-box-footer"></a>
        </div>
    </div>
    <div id="doctor-content" class="col-lg-2 col-xs-6 col-md-3">
        <div class="small-box <?= $doctor_data['bg_color']; ?>">
            <div class="inner">
                <h3>dokter</h3>
                <p>&nbsp;<?= $doctor_data['status']; ?></p>
            </div>
            <a class="small-box-footer"></a>
        </div>
    </div>
    <div id="nurse-content" class="col-lg-2 col-xs-6 col-md-3">
        <div class="small-box <?= $nurse_data['bg_color']; ?>">
            <div class="inner">
                <span style="font-size: 22px; font-weight: bold; letter-spacing: 2px;">Perawat</span><br/>
                <em><span style="letter-spacing: 1px;"><?= '[ ' . ucfirst(strtolower($last_perawat->name)) . ' ]'; ?></span></em>
                <p>&nbsp;<?= $nurse_data['status']; ?></p>
            </div>
            <a class="small-box-footer"></a>
        </div>
    </div>

</div>

<table class="table table-bordered table-condensed" id="clinic-tbl">
    <thead>
        <tr>
            <th class="text-center">NIK</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th class="text-center">Kategori</th>
            <th class="text-center">Masuk</th>
            <th class="text-center">Keluar</th>
            <th class="text-center">Status</th>
            <!--<th class="text-center">Kunjungan Bulan Ini<br/>(Periksa/Istirahat Sakit/Laktasi)</th>-->
            <th class="text-center">Konfirmasi<br/>Manager</th>
        </tr>
    </thead>
    <tbody id="table-container">
        <?php
        /*$dummy_data = app\models\Karyawan::find()
        ->where(['DEPARTEMEN' => 'PRODUCTION ENGINEERING'])
        ->orderBy('NEWID()')
        ->limit(10)
        ->all();*/

        /*$dummy_data = Yii::$app->db_sql_server->createCommand('SELECT * FROM db_owner.KARYAWAN WHERE DEPARTEMEN = \'PRODUCTION ENGINEERING\' ORDER BY RAND() ASC LIMIT 10')
            ->queryAll();*/
        
        foreach ($data as $key => $value) {
            $total_this_month = app\models\KlinikInput::find()
            ->select([
                'nik',
                'total1' => 'SUM(CASE WHEN opsi = 1 THEN 1 ELSE 0 END)',
                'total2' => 'SUM(CASE WHEN opsi = 2 THEN 1 ELSE 0 END)',
                'total3' => 'SUM(CASE WHEN opsi = 3 THEN 1 ELSE 0 END)',
            ])
            ->where([
                'EXTRACT(year_month FROM pk)' => date('Ym'),
                'nik' => $value->nik
            ])
            ->groupBy('nik')
            ->one();

            if ($value->confirm == 0) {
                $konfirmasi = [
                    'text' => 'BELUM',
                    'class' => 'text-red'
                ];
            } else {
                $konfirmasi = [
                    'text' => 'SUDAH',
                    'class' => 'text-green'
                ];
            }

            if ($value->handleby == 'nurse') {
                $handled_by = 'PERAWAT';
            } else {
                $handled_by = 'DOKTER';
            }

            if ($value->opsi == 1) {
                $category = 'PERIKSA';
                $bed_rest_time = date('H:i', strtotime($value->pk));

            } elseif ($value->opsi == 2) {
                $category = 'ISTIRAHAT SAKIT';
                $bed_rest_time = date('H:i', strtotime($value->masuk)) . ' - ' . date('H:i', strtotime($value->keluar));
            }else {
                $category = 'LAKTASI';
                $bed_rest_time = date('H:i', strtotime($value->masuk)) . ' - ' . date('H:i', strtotime($value->keluar));
            }
            $masuk = '-';
            if ($value->masuk != null) {
                $masuk = date('H:i', strtotime($value->masuk));
            }
            $keluar = '-';
            if ($value->keluar != null) {
                $keluar = date('H:i', strtotime($value->keluar));
            }
            /*echo '<tr style="letter-spacing: 2px;">
                <td class="text-center">' . $value->nik . '</td>
                <td>' . $value->nama . '</td>
                <td>' . $value->dept . '</td>
                <td>' . $category . '</td>
                <td class="text-center">' . $masuk . '</td>
                <td class="text-center">' . $keluar . '</td>
                <td class="text-center">' . $total_this_month->total1 . ' / ' . $total_this_month->total2 . ' / ' . $total_this_month->total3 . '</td>
                <td class="text-center ' . $konfirmasi['class'] . '">' . $konfirmasi['text'] . '</td>
            </tr>';*/
            echo '<tr style="letter-spacing: 2px;">
                <td class="text-center">' . $value->nik . '</td>
                <td>' . $value->nama . '</td>
                <td>' . $value->dept . '</td>
                <td class="text-center">' . $category . '</td>
                <td class="text-center">' . $masuk . '</td>
                <td class="text-center">' . $keluar . '</td>
                <td class="text-center">' . $value->last_status . '</td>
                <td class="text-center ' . $konfirmasi['class'] . '">' . $konfirmasi['text'] . '</td>
            </tr>';
        }

        if (count($data) == 0) {
            echo '<tr>
            <td colspan="8">No Visitor Today</td>
            </tr>';
        }
        ?>
        
    </tbody>
    
</table>