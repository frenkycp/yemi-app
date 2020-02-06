<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$wip_location_arr = \Yii::$app->params['wip_location_arr'];
$this->title = [
    'page_title' => $wip_location_arr[$model->location] . ' (WIP) ',
    'tab_title' => $wip_location_arr[$model->location] . ' (WIP) ',
    'breadcrumbs_title' => $wip_location_arr[$model->location] . ' (WIP) ',
];
if ($model->location == 'WW02') {
    $this->title['page_title'] .= '<span class="japanesse light-green">– 木工仕掛り在庫管理</span>';
}
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .control-label {color: white;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center;}
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
    .clinic-container {border: 1px solid white; border-radius: 10px; padding: 5px 20px;}

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        font-size: 2.5em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        height: 120px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important; font-weight: bold !important;}
    .description {font-size: 2.2em; padding-left: 10px;}
    .text-red{color: #ff1c00 !important;}
");


date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 30000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    window.setInterval(function(){
        $('.blinked').toggle();
    },600);
";
$this->registerJs($script, View::POS_HEAD );

?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['wip-control2']),
]); ?>

<div class="row">
    <div class="col-md-3 col-sm-4 col-xs-4">
        <?= $form->field($model, 'location')->dropDownList([
            'WP01' => 'PAINTING',
            'WU01' => 'SPEAKER PROJECT',
            'WW02' => 'WW PROCESS',
        ], [
            'onchange'=>'this.form.submit()',
        ]); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<span style="color: white; font-size: 1.5em;">Last Update : <?= date('Y-m-d H:i'); ?></span>
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th></th>
            <th class="text-center" width="25%">Target</th>
            <th class="text-center" width="25%">Actual</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $key => $value): ?>
            <?php
            if ($value['actual'] >= $value['target']) {
                $total_txt_class = ' text-red';
                $total_src_img = '<i style="font-size: 2.5em;" class="fa fa-close text-red blinked"></i>';
            } else {
                $total_txt_class = ' text-green';
                $total_src_img = '<i style="font-size: 2.5em;" class="fa fa-circle-o text-green"></i>';
            }
            ?>
            <tr>
                <td><?= $value['title']; ?></td>
                <td class="text-center target"><?= $value['target']; ?></td>
                <td class="text-center actual<?= $total_txt_class; ?>"><?= $value['actual']; ?></td>
                <td class="text-center"><?= $total_src_img; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<span style="color: white; font-size: 1.5em;">Jumlah WIP WW (Breakdown)</span>
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th width="25%" class="text-center">L - Series</th>
            <th width="25%" class="text-center">HS - Series</th>
            <th width="25%" class="text-center">P40 - Series</th>
            <th width="25%" class="text-center">XXX - Series</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center actual"><?= number_format($qty_series['l_series']) ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual"><?= number_format($qty_series['hs_series']) ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual"><?= number_format($qty_series['p40_series']) ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual"><?= number_format($qty_series['xxx_series']) ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
    </tbody>
</table>