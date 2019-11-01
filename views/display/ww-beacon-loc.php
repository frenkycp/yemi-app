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
    'page_title' => 'Wood Working Lot Location Mapping <span class="japanesse text-green"></span>',
    'tab_title' => 'Wood Working Lot Location Mapping',
    'breadcrumbs_title' => 'Wood Working Lot Location Mapping'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
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
");

date_default_timezone_set('Asia/Jakarta');

$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');


$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 60000); // milliseconds
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
   });
   $('#myTable').DataTable({
        'pageLength': 5
    });
});");
?>
<span style="color: white; font-size: 1.5em;">Last Update : <?= date('Y-m-d H:i:s'); ?></span>
<div class="row" id="beacon-container">
    <?php
    $loc_title_arr = [
        'PILAR-16I' => 'PILAR-16I (Running Saw, Edge Bander, NCB, Panel Saw)',
        'PILAR-12I' => 'PILAR-12I (DET 3)',
        'PILAR-10I' => 'PILAR-10I (DET 3)',
        'PILAR-6I' => 'PILAR-6I (HVC 3, NCR 6, NCR 7)',
    ];
    foreach ($loc_arr as $key => $loc) {
        $total_qty = 0;
        $total_lot = 0;
        foreach ($data as $key => $value_beacon) {
            if ($value_beacon['lokasi'] == $loc) {
                $total_qty += $value_beacon['lot_qty'];
                $total_lot++;
            }
        }
        ?>
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $loc_title_arr[$loc]; ?></h3>
                </div>
                <div class="panel-body" style="min-height: 300px;">
                    <div class="row">
                        <div class="col-md-6">
                            <span style="font-size: 1.2em;">Total Lot : <b><?= number_format($total_lot); ?></b></span>
                        </div>
                        <div class="col-md-6">
                            <span style="font-size: 1.2em;">Total Qty : <b><?= number_format($total_qty); ?></b></span>
                        </div>
                    </div>
                    <hr>
                    <?php

                    if (true) {
                        foreach ($kelompok_machine as $key => $kelompok_data) {
                            ?>
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= $kelompok_data->kelompok; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    foreach ($data as $key => $value_beacon) {
                                        if ($value_beacon['lokasi'] == $loc && $value_beacon['kelompok'] == $kelompok_data->kelompok) {

                                            
                                            //$date1 = new \DateTime();
                                            $time_second = strtotime(date('Y-m-d H:i:s'));
                                            $time_first = strtotime($value_beacon['start_date']);
                                            $diff_seconds = $time_second - $time_first;
                                            $diff_hours = round(($diff_seconds / 3600), 1);
                                            $txt_class = ' btn-success';
                                            $start_time = '-';
                                            if ($value_beacon['start_date'] != null) {
                                                $start_time = date('d M\' Y H:i', strtotime($value_beacon['start_date']));
                                            }
                                            if ($diff_hours > 24) {
                                                $txt_class = ' btn-danger';
                                            }
                                            //echo Html::a('<i style="font-size: 2.5em; margin: 3px 3px;" class="fa fa-fw fa-cart-plus' . $txt_class . '" title="Beacon ID : ' . $value_beacon['minor'] . '&#010;Lot number : ' . $value_beacon['lot_number'] . '&#010;Model : ' . $value_beacon['model_group'] . '&#010;Machine ID : ' . $value_beacon['mesin_id'] . '&#010;Machine Desc. : ' . $value_beacon['mesin_description'] . '&#010;Start Time (First Process): ' . $start_time . '"></i>', ['get-beacon-detail', 'minor' => $value_beacon['minor']], ['class' => 'popup_btn']);
                                            echo Html::a('<span style="font-size: 1.1em; margin: 3px 3px;" class="btn btn-xs' . $txt_class . '" title="Beacon ID : ' . $value_beacon['minor'] . '&#010;Lot number : ' . $value_beacon['lot_number'] . '&#010;Model : ' . $value_beacon['model_group'] . '&#010;Machine ID : ' . $value_beacon['mesin_id'] . '&#010;Machine Desc. : ' . $value_beacon['mesin_description'] . '&#010;Start Time (First Process): ' . $start_time . '">' . $value_beacon['minor'] . '</span>', ['ww-beacon-shipping', 'minor' => $value_beacon['minor']], ['class' => '', 'target' => '_blank']);
                                            
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php }
                    } else {
                        foreach ($data as $key => $value_beacon) {
                            if ($value_beacon['lokasi'] == $loc) {

                                
                                //$date1 = new \DateTime();
                                $time_second = strtotime(date('Y-m-d H:i:s'));
                                $time_first = strtotime($value_beacon['start_date']);
                                $diff_seconds = $time_second - $time_first;
                                $diff_hours = round(($diff_seconds / 3600), 1);
                                $txt_class = ' text-green';
                                $start_time = '-';
                                if ($value_beacon['start_date'] != null) {
                                    $start_time = date('d M\' Y H:i', strtotime($value_beacon['start_date']));
                                }
                                if ($diff_hours > 24) {
                                    $txt_class = ' text-red';
                                }
                                //echo Html::a('<i style="font-size: 2.5em; margin: 3px 3px;" class="fa fa-fw fa-cart-plus' . $txt_class . '" title="Beacon ID : ' . $value_beacon['minor'] . '&#010;Lot number : ' . $value_beacon['lot_number'] . '&#010;Model : ' . $value_beacon['model_group'] . '&#010;Machine ID : ' . $value_beacon['mesin_id'] . '&#010;Machine Desc. : ' . $value_beacon['mesin_description'] . '&#010;Start Time (First Process): ' . $start_time . '"></i>', ['get-beacon-detail', 'minor' => $value_beacon['minor']], ['class' => 'popup_btn']);
                                echo Html::a('<i style="font-size: 2.5em; margin: 3px 3px;" class="fa fa-fw fa-cart-plus' . $txt_class . '" title="Beacon ID : ' . $value_beacon['minor'] . '&#010;Lot number : ' . $value_beacon['lot_number'] . '&#010;Model : ' . $value_beacon['model_group'] . '&#010;Machine ID : ' . $value_beacon['mesin_id'] . '&#010;Machine Desc. : ' . $value_beacon['mesin_description'] . '&#010;Start Time (First Process): ' . $start_time . '"></i>', ['ww-beacon-shipping', 'minor' => $value_beacon['minor']], ['class' => '', 'target' => '_blank']);
                                
                            }
                        }
                    }
                    
                    
                    ?>
                </div>
            </div>
        </div>
    <?php }
    ?>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Beacon Status Information</h3>
    </div>
    <div class="panel-body">
        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Beacon ID</th>
                    <th>Location</th>
                    <th>Lot Number</th>
                    <th>Model</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Lot Qty</th>
                    <th>Last Machine</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($beacon_data as $key => $value_beacon) {
                    ?>
                    <tr>
                        <td><?= $value_beacon['minor']; ?></td>
                        <td><?= $value_beacon['lokasi']; ?></td>
                        <td><?= $value_beacon['lot_number']; ?></td>
                        <td><?= $value_beacon['model_group']; ?></td>
                        <td><?= $value_beacon['gmc']; ?></td>
                        <td><?= $value_beacon['gmc_desc']; ?></td>
                        <td><?= $value_beacon['lot_qty'] == null ? '' : number_format($value_beacon['lot_qty']); ?></td>
                        <td><?= $value_beacon['mesin_id'] == null ? '' : $value_beacon['mesin_id'] . ' - ' . $value_beacon['mesin_description']; ?></td>
                    </tr>
                <?php }
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