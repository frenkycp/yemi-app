<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'Production Progress <span class="japanesse light-green">(生産進捗)</span> VMS (D-1)',
    'tab_title' => 'Production Progress (D-1)',
    'breadcrumbs_title' => 'Production Progress (D-1)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 1.3em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .badge {font-weight: normal;}

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 50px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.5px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 40px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: white !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 50px;
        background: #000;
        color: white;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #yesterday-tbl > tbody > tr > td{
        border:1px solid #777474;
        background: #000;
        color: #FFF;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 2px;
        //height: 100px;
    }
    #popup-tbl > tfoot > tr > td {
        font-weight: bold;
        background-color: rgba(0, 0, 150, 0.3);
    }
    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

/*$script = "
    $('document').ready(function() {
        $('#popup-tbl').DataTable({
            'order': [[ 6, 'desc' ]]
        });
    });
";
$this->registerJs($script, View::POS_HEAD );*/

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

$this->registerJs("$(function() {
   $('.popup_btn').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
     $('#popup-tbl').DataTable({
        'order': [[ 6, 'desc' ]]
    });
   });
});");
// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_data_arr);
echo '</pre>';*/
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['vms-vs-flo']),
]); ?>

<div class="row" style="display: none;">
    
    
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<br/>
<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="">BU</th>
            <th class="text-center">PLAN</th>
            <th class="text-center">ACTUAL</th>
            <th class="text-center">BALANCE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $tmp_total_plan = $tmp_total_actual = $tmp_total_balance = $tmp_total_pct = 0;
        foreach ($tmp_data_yesterday as $key => $value): 
            if ($key == 'OTHER') {
                $key = 'KD PARTS';
            } elseif ($key == 'PIANO') {
                $key = 'PIANO (KD)';
            }
            $tmp_total_plan += $value['plan'];
            $tmp_total_actual += $value['actual'];
            $tmp_total_balance += $value['balance'];
            $text_class = '';
            if ($value['balance'] < 0) {
                $text_class = 'text-red';
            }
            if ($value['balance'] > 0) {
                $text_class = 'text-green';
            }
            ?>
            <tr>
                <td class=""><?= $key; ?></td>
                <td class="text-center"><?= number_format($value['plan']); ?> <span style="font-size: 0.4em;">SET</span></td>
                <td class="text-center"><?= number_format($value['actual']); ?> <span style="font-size: 0.4em;">SET</span></td>
                <td class="text-center">
                    
                    <?php
                    if ($key == 'AV' && $value['balance'] < 0) {
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="<?= $text_class; ?>" style="font-weight: bold;"><?= number_format($value['balance']); ?></span> <span style="font-size: 0.4em;">SET</span>
                            </div>
                            <div class="col-sm-6" style="border-left: 2px solid white;">
                                <div class="text-left" style="font-size: 14px;">
                                    Top Minus :
                                    <ol>
                                        <?php foreach ($tmp_top_minus_av as $key => $value): ?>
                                            <li>
                                                <?= $value->ITEM . ' | ' . $value->ITEM_DESC . ' | <b class="">' . $value->BALANCE_QTY . '</b>'; ?>
                                            </li>
                                        <?php endforeach ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    <?php } elseif ($key == 'PA' && $value['balance'] < 0) {
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="<?= $text_class; ?>" style="font-weight: bold;"><?= number_format($value['balance']); ?></span> <span style="font-size: 0.4em;">SET</span>
                            </div>
                            <div class="col-sm-6" style="border-left: 2px solid white;">
                                <div class="text-left" style="font-size: 14px;">
                                    Top Minus :
                                    <ol>
                                        <?php foreach ($tmp_top_minus_pa as $key => $value): ?>
                                            <li>
                                                <?= $value->ITEM . ' | ' . $value->ITEM_DESC . ' | <b class="">' . $value->BALANCE_QTY . '</b>'; ?>
                                            </li>
                                        <?php endforeach ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <span class="<?= $text_class; ?>" style="font-weight: bold;"><?= number_format($value['balance']); ?></span> <span style="font-size: 0.4em;">SET</span>
                    <?php }
                    ?>
                </td>
            </tr>
        <?php endforeach; 
        if ($tmp_total_plan > 0) {
            $tmp_total_pct = round(($tmp_total_actual / $tmp_total_plan) * 100);
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <?php
            $footer_text_class = '';
            if ($tmp_total_balance < 0) {
                $footer_text_class = 'text-red';
            }
            if ($tmp_total_balance > 0) {
                $footer_text_class = 'text-green';
            }
            ?>
            <td class="">TOTAL</td>
            <td class="text-center"><?= number_format($tmp_total_plan); ?> <span style="font-size: 0.4em;">SET</span></td>
            <td class="text-center"><?= number_format($tmp_total_actual); ?> <span style="font-size: 0.4em;">SET</span></td>
            <td class="text-center"><span class="<?= $footer_text_class; ?>" style="font-weight: bold;"><?= number_format($tmp_total_balance); ?></span> <span style="font-size: 0.4em;">SET</span></td>
        </tr>
    </tfoot>
</table>
<span style="color: silver; font-size: 1.5em;"><i>VMS Version : <?= $vms_version; ?></i><i style="display: none;">Last Update : <?= date('Y-m-d H:i:s'); ?></i></span>
<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Detail Info</h3>',
        'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();
?>