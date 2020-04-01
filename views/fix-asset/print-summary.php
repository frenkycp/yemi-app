<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = [
    'page_title' => null,
    'tab_title' => null,
    'breadcrumbs_title' => null
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .content-header {display: none;}
    .container {width: auto;}
    .bap-header {font-weight: bold;}
    @media print {
        .footer,
        #non-printable {
            display: none !important;
        }
        #printable {
            display: block;
        }
    }
    #table-content {padding-left: 50px; width: 400px;}
    table, th, td {border: 1px solid black !important;}
    table {margin-bottom: unset !important;}
    .signature-title, .signature-content {border: 1px solid black; text-align: center;}
    .signature-content {min-height: 100px;}
    .signature {width: 180px; margin: 50px;}
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    $('document').ready(function() {
        window.print();
        setTimeout(window.close, 500);
    });
";
$this->registerJs($script, View::POS_HEAD );

// echo '<pre>';
// print_r($data_completion);
// echo '</pre>';
//echo Yii::$app->request->baseUrl;
$total_qty = $summary_data->total_ok + $summary_data->total_ng + $summary_data->ng_plan_scrap + $summary_data->total_standby + $summary_data->total_repair + $summary_data->total_open;
$total_qty2 = $summary_data->label_y + $summary_data->label_n;
?>

<div class="bap-header text-center">
    BERITA ACARA PEMERIKSAAN<br/>
    STOCK TAKING FIX ASSET
</div>
<br/>
<div class="header-1">
    Dengan ini menyatakan bahwa<br/>
    Tanggal&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;<?= date('d-M-y'); ?><br/>
    Dept&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;<?= $department_name; ?><br/>
</div>
<br/>
Telah melaksanakan kegiatan Stock Taking Fix Asset terhadap fixed asset dengan hasil sebagai berikut :
<br/>
<br/>
<div id="table-content">
    <table class="table table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <th class="text-center" width="30px">NO</th>
                <th class="text-center" width="100px">STATUS</th>
                <th class="text-center" width="60px">JUMLAH</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>OK RESULT</td>
                <td class="text-center"><?= number_format($summary_data->total_ok); ?></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>NG (NO SCRAP)</td>
                <td class="text-center"><?= number_format($summary_data->total_ng); ?></td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>NG (PROPOSE SCRAP)</td>
                <td class="text-center"><?= number_format($summary_data->ng_plan_scrap); ?></td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>STANDBY</td>
                <td class="text-center"><?= number_format($summary_data->total_standby); ?></td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td>REPAIR</td>
                <td class="text-center"><?= number_format($summary_data->total_repair); ?></td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td>NOT FUND</td>
                <td class="text-center"><?= number_format($summary_data->total_open); ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center" colspan="2">Total</td>
                <td class="text-center"><?= number_format($total_qty); ?></td>
            </tr>
        </tfoot>
    </table>
    <span>*detail list terlampir</span><br/><br/>

    <table class="table table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">LABEL</th>
                <th class="text-center">JUMLAH</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td class="">ADA</td>
                <td class="text-center"><?= number_format($summary_data->label_y); ?></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td class="">TIDAK ADA</td>
                <td class="text-center"><?= number_format($summary_data->label_n); ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center" colspan="2">TOTAL</td>
                <td class="text-center"><?= number_format($total_qty2); ?></td>
            </tr>
        </tfoot>
    </table>
    <span>*detail list terlampir</span><br/><br/>
</div>

<div id="close-content">
    Demikian berita acara pemeriksaaan Stock Taking Fixed Asset ini dibuat, agar dapat dipergunakan sebagaimana mestinya.
</div>

<div class="pull-left" width="50%">
    <div class="signature">
        <div class="signature-title">PIC Stock Taking</div>
        <div class="signature-content"></div>
    </div>
</div>
<div class="pull-right" width="50%">
    <div class="signature">
        <div class="signature-title">Approved by</div>
        <div class="signature-content"></div>
    </div>
</div>