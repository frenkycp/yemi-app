<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\db\Expression;

$this->title = [
    'page_title' => '',
    'tab_title' => 'CLINIC',
    'breadcrumbs_title' => 'CLINIC'
];

$this->registerCss("
	.japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
    .form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
	.content-header {color: white;}
    .box-body {background-color: #33383D;}
	.box-title {font-weight: bold;}
	.box-header .box-title, .control-label{font-size: 1.5em;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}

    #clinic-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #clinic-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #858689;
        color: white;
        font-size: 22px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #clinic-tbl > tbody > tr > td{
        //border:1px solid #29B6F6;
        font-size: 16px;
        background-color: #B3E5FC;
        font-weight: 1000;
        color: #555;
        vertical-align: middle;
    }
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 60000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
    $(document).ready(function() {
        var i = 0;
        setInterval(function() {
            i++;
            if(i%2 == 0){
                $("#run-text").css("background-color", "#00ff00");
                //$("#run-text").css("color", "white");
            } else {
                $("#run-text").css("background-color", "yellow");
                //$("#run-text").css("color", "#555");
            }
        }, 300);
    });
JS;

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
                <h3><?= $today_visitor; ?></h3>
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
                <h3><?= $monthly_visitor; ?></h3>
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
                <h3><?= $available_beds; ?>/3</h3>
                <p>Ruangan Tersedia</p>
            </div>
            <div class="icon">
                <i class="glyphicon glyphicon-bed"></i>
            </div>
            <a class="small-box-footer"></a>
        </div>
    </div>
    <div class="col-lg-2 col-xs-6 col-md-3">
        <div class="small-box <?= $doctor_data['bg_color']; ?>">
            <div class="inner">
                <h3>doctor</h3>
                <p>&nbsp;<?= $doctor_data['status']; ?></p>
            </div>
            <a class="small-box-footer"></a>
        </div>
    </div>
    <div class="col-lg-2 col-xs-6 col-md-3">
        <div class="small-box <?= $nurse_data['bg_color']; ?>">
            <div class="inner">
                <h3>Paramedis</h3>
                <p>&nbsp;<?= $nurse_data['status']; ?></p>
            </div>
            <a class="small-box-footer"></a>
        </div>
    </div>
</div>

<table class="table table-bordered" id="clinic-tbl">
    <thead>
        <tr>
            <th class="text-center">NIK</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Kategori</th>
            <th class="text-center">Waktu</th>
            <th class="text-center">Kunjungan Bulan Ini</th>
        </tr>
    </thead>
    <tbody>
        <?php
        /*$dummy_data = app\models\Karyawan::find()
        ->where(['DEPARTEMEN' => 'PRODUCTION ENGINEERING'])
        ->orderBy('NEWID()')
        ->limit(10)
        ->all();*/

        /*$dummy_data = Yii::$app->db_sql_server->createCommand('SELECT * FROM db_owner.KARYAWAN WHERE DEPARTEMEN = \'PRODUCTION ENGINEERING\' ORDER BY RAND() ASC LIMIT 10')
            ->queryAll();*/
        
        foreach ($data as $key => $value) {
            $random_visit = rand(1, 5);
            $total_this_month = app\models\KlinikInput::find()
            ->where([
                'EXTRACT(year_month FROM pk)' => date('Ym'),
                'nik' => $value->nik
            ])
            ->count();
            if ($value->opsi == 1) {
                $category = 'CHECK UP';
                $bed_rest_time = date('H:i', strtotime($value->pk));

            } elseif ($value->opsi == 2) {
                $category = 'BEDREST';
                $bed_rest_time = date('H:i', strtotime($value->masuk)) . ' - ' . date('H:i', strtotime($value->keluar));
            }else {
                $category = 'LACTATION';
                $bed_rest_time = date('H:i', strtotime($value->masuk)) . ' - ' . date('H:i', strtotime($value->keluar));
            }
            echo '<tr>
                <td class="text-center">' . $value->nik . '</td>
                <td>' . $value->nama . '</td>
                <td>' . $value->dept . '</td>
                <td>' . $category . '</td>
                <td class="text-center">' . $bed_rest_time . '</td>
                <td class="text-center">' . $total_this_month . '</td>
            </tr>';
        }

        if (count($data) == 0) {
            echo '<tr>
            <td colspan="6">No Visitor Today</td>
            </tr>';
        }
        ?>
        
    </tbody>
    
</table>