<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Oven Monitoring (Painting) <span class="japanesse light-green"></span>',
    'tab_title' => 'Oven Monitoring (Painting) ',
    'breadcrumbs_title' => 'Oven Monitoring (Painting) ',
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .tab-content > .tab-pane,
    .pill-content > .pill-pane {
        display: block;     
        height: 0;          
        overflow-y: hidden; 
    }

    .tab-content > .active,
    .pill-content > .active {
        height: auto;
    }
    th {
        vertical-align: middle !important;
    }
");

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

?>

<div class="row">
    <?php foreach ($data as $key => $value): ?>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= $value['description'] ?></h3>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-bordered table-striped">
                        <thead style="font-size: 1.5em;">
                            <tr>
                                <th class="text-center" rowspan="2">Lot Number</th>
                                <th class="text-center" rowspan="2">Beacon ID</th>
                                <!-- <th class="text-center" rowspan="2">Part No</th> -->
                                <th rowspan="2">Part Name</th>
                                <th class="text-center" rowspan="2">Qty</th>
                                <th class="text-center" colspan="2">Oven Time</th>
                            </tr>
                            <tr>
                                <th>(Target)</th>
                                <th>(Actual)</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 1.5em;">
                            <?php foreach ($value['data'] as $key2 => $value2): ?>
                                <?php
                                $datetime1 = new \DateTime(date('Y-m-d H:i:s', strtotime($value2->start_date)));
                                $datetime2 = new \DateTime(date('Y-m-d H:i:s'));
                                $interval = $datetime1->diff($datetime2);
                                $minutes = $interval->days * 24 * 60;
                                $minutes += $interval->h * 60;
                                $minutes += $interval->i;
                                ?>
                                <tr class="<?= $minutes > $value2->oven_time ? 'danger' : ''; ?>">
                                    <td class="text-center"><?= $value2->lot_number; ?></td>
                                    <td class="text-center"><?= $value2->minor; ?></td>
                                    <!-- <td class="text-center"><?= ''; //$value2->gmc; ?></td> -->
                                    <td><?= $value2->gmc_desc; ?></td>
                                    <td class="text-center"><?= number_format($value2->lot_qty); ?></td>
                                    <td class="text-center"><?= number_format($value2->oven_time); ?></td>
                                    <td class="text-center"><?= number_format($minutes); ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>