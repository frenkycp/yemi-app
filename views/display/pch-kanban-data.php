<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;

$this->title = [
    'page_title' => 'Office Kanban Workflow (Supplier Payment) <span class="japanesse light-green">ベンダー支払い処理</span>',
    'tab_title' => 'Office Kanban Workflow',
    'breadcrumbs_title' => 'Office Kanban Workflow'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .modal-dialog {width: 1000px;}

    #main-table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #main-table > thead > tr > th{
        border:1px solid #005a8e;
        background-color: " . \Yii::$app->params['bg-blue'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #005a8e;
        vertical-align: middle;
    }
    #main-table > tbody > tr > td{
        border:1px solid #005a8e;
        font-size: 3.5em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        height: 130px;
    }
    #main-table > tfoot > tr > td{
        border:1px solid #005a8e;
        font-size: 3.5em;
        background-color: rgba(255, 255, 255, 0.1);
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 130px;
    }
    .icon-status {font-size : 2em;}

");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 1800000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    window.setInterval(function(){
        $('.blinked').toggle();
    },600);

    $(document).ready(function(){
        var arr_modal = ['direct-balance-1', 'direct-balance-2', 'direct-balance-3', 'direct-balance-4', 'indirect-balance-1', 'indirect-balance-2', 'indirect-balance-3', 'indirect-balance-4', 'direct-acc-target', 'indirect-acc-target'];
        $.each(arr_modal, function(index, value){
            $('#'+value).css('text-decoration', 'underline');
            $('#'+value).attr('title', 'Click to view detail ...');
            $('#'+value).click(function(){
                //alert('Balance 1');
                $('#modal-' + value).modal('show');
            });
        });
        
    });
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
    'action' => Url::to(['pch-kanban-data']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->textInput(['maxlength' => 6]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>


<table id="main-table" class="table table-responsive">
    <thead>
        <tr>
            <th rowspan="3" style="background: transparent; border-left: 0px;"></th>
            <th class="text-center">WAREHOUSE <span class="japanesse light-green">倉庫</span></th>
            <th class="text-center" colspan="4">PURCHASING <span class="japanesse light-green">購買</span></th>
            <th class="text-center" colspan="4">ACCOUNTING <span class="japanesse light-green">経理</span></th>
        </tr>
        <tr>
            <th class="text-center">Kanban</th>
            <th class="text-center" colspan="2">Document Received</th>
            <th class="text-center" colspan="2">Document Verification</th>
            <th class="text-center" colspan="2">Accounting Verification</th>
            <th class="text-center" colspan="2">Accounting Paid</th>
        </tr>
        <tr>
            <th class="text-center">Document</th>
            <th class="text-center">TARGET</th>
            <th class="text-center">BALANCE</th>
            <th class="text-center">TARGET</th>
            <th class="text-center">BALANCE</th>
            <th class="text-center">TARGET</th>
            <th class="text-center">BALANCE</th>
            <th class="text-center">TARGET</th>
            <th class="text-center">BALANCE</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>DIRECT <span class="japanesse light-green">直材</span></td>
            <td class="text-center"><?= number_format($data['direct']['kanban_doc']); ?></td>
            <td class="text-center"><?= number_format($data['direct']['pch']['received']['target']); ?></td>
            <td class="text-center"><?= $data['direct']['pch']['received']['balance'] == 0 ? '0' : Html::a(number_format($data['direct']['pch']['received']['balance']), '#', ['style' => 'color: red; font-weight: bold;', 'id' => 'direct-balance-1']); ?></td>
            <td class="text-center"><?= number_format($data['direct']['pch']['verification']['target']); ?></td>
            <td class="text-center"><?= $data['direct']['pch']['verification']['balance'] == 0 ? '0' : Html::a(number_format($data['direct']['pch']['verification']['balance']), '#', ['style' => 'color: red; font-weight: bold;', 'id' => 'direct-balance-2']); ?></td>
            <td class="text-center"><?= $data['direct']['acc']['verification']['target'] == 0 ? '0' : Html::a(number_format($data['direct']['acc']['verification']['target']), '#', ['style' => 'color: white; font-weight: bold;', 'id' => 'direct-acc-target']); ?></td>
            <td class="text-center"><?= $data['direct']['acc']['verification']['balance'] == 0 ? '0' : Html::a(number_format($data['direct']['acc']['verification']['balance']), '#', ['style' => 'color: red; font-weight: bold;', 'id' => 'direct-balance-3']); ?></td>
            <td class="text-center"><?= number_format($data['direct']['acc']['paid']['target']); ?></td>
            <td class="text-center"><?= $data['direct']['acc']['paid']['balance'] == 0 ? '0' : Html::a(number_format($data['direct']['acc']['paid']['balance']), '#', ['style' => 'color: red; font-weight: bold;', 'id' => 'direct-balance-4']); ?></td>
        </tr>
        <tr>
            <td>INDIRECT <span class="japanesse light-green">間材</span></td>
            <td class="text-center"><?= number_format($data['indirect']['kanban_doc']); ?></td>
            <td class="text-center"><?= number_format($data['indirect']['pch']['received']['target']); ?></td>
            <td class="text-center"><?= $data['indirect']['pch']['received']['balance'] == 0 ? '0' : Html::a(number_format($data['indirect']['pch']['received']['balance']), '#', ['style' => 'color: red; font-weight: bold;', 'id' => 'indirect-balance-1']); ?></td>
            <td class="text-center"><?= number_format($data['indirect']['pch']['verification']['target']); ?></td>
            <td class="text-center"><?= $data['indirect']['pch']['verification']['balance'] == 0 ? '0' : Html::a(number_format($data['indirect']['pch']['verification']['balance']), '#', ['style' => 'color: red; font-weight: bold;', 'id' => 'indirect-balance-2']); ?></td>
            <td class="text-center"><?= $data['indirect']['acc']['verification']['target'] == 0 ? '0' : Html::a(number_format($data['indirect']['acc']['verification']['target']), '#', ['style' => 'color: white; font-weight: bold;', 'id' => 'indirect-acc-target']); ?></td>
            <td class="text-center"><?= $data['indirect']['acc']['verification']['balance'] == 0 ? '0' : Html::a(number_format($data['indirect']['acc']['verification']['balance']), '#', ['style' => 'color: red; font-weight: bold;', 'id' => 'indirect-balance-3']); ?></td>
            <td class="text-center"><?= number_format($data['indirect']['acc']['paid']['target']); ?></td>
            <td class="text-center"><?= $data['indirect']['acc']['paid']['balance'] == 0 ? '0' : Html::a(number_format($data['indirect']['acc']['paid']['balance']), '#', ['style' => 'color: red; font-weight: bold;', 'id' => 'indirect-balance-4']); ?></td>
        </tr>
    </tbody>
    <tfoot>
        <td class="text-center">Total</td>
        <td class="text-center"><?= number_format($data['direct']['kanban_doc'] + $data['indirect']['kanban_doc']); ?></td>
        <td class="text-center"><?= number_format($data['direct']['pch']['received']['target'] + $data['indirect']['pch']['received']['target']); ?></td>
        <td class="text-center" style="<?= ($data['direct']['pch']['received']['balance'] + $data['indirect']['pch']['received']['balance']) < 0 ? 'color: red; font-weight: bold;' : ''; ?>">
            <?= number_format($data['direct']['pch']['received']['balance'] + $data['indirect']['pch']['received']['balance']); ?>
        </td>
        <td class="text-center"><?= number_format($data['direct']['pch']['verification']['target'] + $data['indirect']['pch']['verification']['target']); ?></td>
        <td class="text-center" style="<?= ($data['direct']['pch']['verification']['balance'] + $data['indirect']['pch']['verification']['balance']) < 0 ? 'color: red; font-weight: bold;' : ''; ?>">
            <?= number_format($data['direct']['pch']['verification']['balance'] + $data['indirect']['pch']['verification']['balance']); ?>
        </td>
        <td class="text-center"><?= number_format($data['direct']['acc']['verification']['target'] + $data['indirect']['acc']['verification']['target']); ?></td>
        <td class="text-center" style="<?= ($data['direct']['acc']['verification']['balance'] + $data['indirect']['acc']['verification']['balance']) < 0 ? 'color: red; font-weight: bold;' : ''; ?>">
            <?= number_format($data['direct']['acc']['verification']['balance'] + $data['indirect']['acc']['verification']['balance']); ?>
        </td>
        <td class="text-center"><?= number_format($data['direct']['acc']['paid']['target'] + $data['indirect']['acc']['paid']['target']); ?></td>
        <td class="text-center" style="<?= ($data['direct']['acc']['paid']['balance'] + $data['indirect']['acc']['paid']['balance']) < 0 ? 'color: red; font-weight: bold;' : ''; ?>">
            <?= number_format($data['direct']['acc']['paid']['balance'] + $data['indirect']['acc']['paid']['balance']); ?>
        </td>
    </tfoot>
</table>
<div class="progress-group">
    <span class="progress-text" style="color: white;">Target</span>
    <div class="progress">
        <div class="progress-bar progress-bar-danger" style="width: 25%">
            <span class="" style="color: black; font-weight: bold;">0% - 25% Complete (max. 5<sup>th</sup>)</span>
        </div>
        <div class="progress-bar progress-bar-warning" style="width: 25%">
            <span class="" style="color: black; font-weight: bold;">26% - 50% Complete (max. 10<sup>th</sup>)</span>
        </div>
        <div class="progress-bar progress-bar-info" style="width: 25%">
            <span class="" style="color: black; font-weight: bold;">51% - 75% Complete (max. 15<sup>th</sup>)</span>
        </div>
        <div class="progress-bar progress-bar-success" style="width: 25%">
            <span class="" style="color: black; font-weight: bold;">76% - 100% Complete (max. 20<sup>th</sup>)</span>
        </div>
    </div>
</div>
<div class="progress-group">
    <span class="progress-text" style="color: white;">Actual</span>
    <div class="progress">
        <?php
        if ($completion <= 25) {
            $progress_class = 'progress-bar-danger';
        } elseif ($completion <= 50) {
             $progress_class = 'progress-bar-warning';
        }
        ?>
        <div class="progress-bar progress-bar-success progress-bar-striped active" style="width: <?= $completion . '%'; ?>">
            <span class="" style="color: black; font-weight: bold;"><?= $completion; ?>%</span>
        </div>
    </div>
</div>

<?php
foreach ($modal_data as $direct_indirect => $value) {
    foreach ($value as $key => $detail) {
        Modal::begin([
            'header' => '<h2>Detail Payment</h2>',
            'id' => 'modal-' . $direct_indirect . '-' . $key,
            'size' => 'modal-lg'
        ]);

        echo "<div id='modalContent'>";
        echo '<table class="table table-responsive table-bordered table-striped" style="font-size: 12px;">';
        echo '<thead>
            <tr>
                <th>No</th>
                <th>Period</th>
                <th>Vendor Code</th>
                <th>Vendor Name</th>
                <th>Voucher No.</th>
                <th>Invoice Act.</th>
                <th>Do</th>
                <th>Currency</th>
                <th>Ammount</th>
                <th>PIC</th>
                <th>Division</th>
                <th>Term</th>
            </tr>
        </thead>';
        echo '<tbody>';
        $no = 1;
        foreach ($detail as $key => $value) {
            echo '<tr>
                <td>' . $no++ . '</td>
                <td>' . $value['period'] . '</td>
                <td>' . $value['vendor_code'] . '</td>
                <td>' . $value['vendor_name'] . '</td>
                <td>' . $value['voucher_no'] . '</td>
                <td>' . $value['invoice_act'] . '</td>
                <td>' . $value['do'] . '</td>
                <td>' . $value['currency'] . '</td>
                <td>' . round($value['amount'], 2) . '</td>
                <td>' . $value['pic'] . '</td>
                <td>' . $value['division'] . '</td>
                <td>' . $value['term'] . '</td>
            </tr>';
        }
        echo '</tbody>';
        echo '</table>';
        
        echo "</div>";

        Modal::end();
    }
    
}

?>