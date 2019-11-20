<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = [
    'page_title' => null,
    'tab_title' => 'SMT Injection Today',
    'breadcrumbs_title' => 'SMT Injection Today'
];
$color = 'ForestGreen';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .container {width: auto;}
    
    
    //.actual {font-size: 4em; font-weight:bold;}
    body, .content-wrapper {background-color: #000;}
    .icon-status {font-size : 3em;}

    #smt-today{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #smt-today > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #595F66;
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #smt-today > tbody > tr > td{
        border:1px solid #777474;
        font-size: 28px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
    }
    td {vertical-align: middle !important; height: 120px;}
    .target, .actual {font-size: 4em !important; font-weight: bold !important;}
");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    window.setInterval(function(){
        $('.blinked').toggle();
    },600);

JS;
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data_losstime);
echo '</pre>';*/

$img_class = $spr_txt_class = '';
foreach ($spr_aoi as $key => $value) {
    if ($value >= 97) {
        $spr_txt_class[] = ' text-green';
        $spr_icon[] = '<i class="fa fa-circle-o text-green icon-status"></i>';
    } elseif ($spr_aoi[0] >= 95 && $spr_aoi[0] < 97) {
        $spr_txt_class[] = ' text-yellow';
        $spr_icon[] = '<i class="fa warning text-yellow icon-status blinked"></i>';
    } else {
        $spr_txt_class[] = ' text-danger';
        $spr_icon[] = '<i class="fa fa-close text-red icon-status blinked"></i>';
    }
}

foreach ($dandori_pct as $key => $value) {
    
    if ($value > 10) {
        $dandori_txt_class[] = ' text-danger';
        $dandori_icon[] = '<i class="fa fa-close text-red icon-status blinked"></i>';
    } else {
        $dandori_txt_class[] = ' text-green';
        $dandori_icon[] = '<i class="fa fa-circle-o text-green icon-status"></i>';
    }
}


$target_delay = 500;
$target_stock = 2000;
?>
<div class="row">
    <div class="col-md-12">
        <table id="smt-today" class="table table-responsive table-bordered">
            <thead>
                <tr style="font-size: 3em;" class="">
                    <th class="text-center" colspan="2">SMT</th>
                    <th class="text-center">TARGET</th>
                    <th class="text-center">ACTUAL</th>
                    <th class="text-center" style="width: 200px;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-size: 2em;" rowspan="2">SPR (AOI)</td>
                    <td class="text-center"><?= strtoupper(date('d F Y')); ?></td>
                    <td class="text-center target">99.5 %</td>
                    <td class="text-center actual<?= $spr_txt_class[0]; ?>"><?= $spr_aoi[0]; ?> %</td>
                    <td class="text-center" style="">
                        <?php
                        echo $spr_icon[0];
                        //echo Html::img($img_link, ['width' => '100', 'class' => $img_class]);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><?= strtoupper(date('F Y')); ?></td>
                    <td class="text-center target">99.5 %</td>
                    <td class="text-center actual<?= $spr_txt_class[1]; ?>"><?= $spr_aoi[1]; ?> %</td>
                    <td class="text-center" style="">
                        <?php
                        echo $spr_icon[1];
                        //echo Html::img($img_link, ['width' => '100', 'class' => $img_class]);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 2em;" rowspan="2">INTERNAL SETUP</td>
                    <td class="text-center"><?= strtoupper(date('d F Y')); ?></td>
                    <td class="text-center target">10 %</td>
                    <td class="text-center actual<?= $dandori_txt_class[0]; ?>"><?= $dandori_pct[0]; ?> %</td>
                    <td class="text-center">
                        <?php
                        echo $dandori_icon[0];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><?= strtoupper(date('F Y')); ?></td>
                    <td class="text-center target">10 %</td>
                    <td class="text-center actual<?= $dandori_txt_class[1]; ?>"><?= $dandori_pct[1]; ?> %</td>
                    <td class="text-center" style="">
                        <?php
                        echo $dandori_icon[1];
                        //echo Html::img($img_link, ['width' => '100', 'class' => $img_class]);
                        ?>
                    </td>
                </tr>
                <tr>
                    <?php
                    if ($total_delay > $target_delay) {
                        $delay_txt_class = ' text-red';
                        $delay_icon = '<i class="fa fa-close icon-status blinked' . $delay_txt_class . '"></i>';
                    } else {
                        $delay_txt_class = ' text-green';
                        $delay_icon = '<i class="fa fa-circle-o icon-status' . $delay_txt_class . '"></i>';
                    }
                    ?>
                    <td style="font-size: 2em;" colspan="2">DELAY PRODUCTION</td>
                    <td class="text-center target"><?= number_format($target_delay); ?> PCS</td>
                    <td class="text-center actual<?= $delay_txt_class; ?>"><?= number_format($total_delay); ?> PCS</td>
                    <td class="text-center">
                        <?php
                        echo $delay_icon;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 2em;" colspan="2">STOCK WIP</td>
                    <td class="text-center target"><?= number_format($target_stock); ?> PCS</td>
                    <td class="text-center actual<?= $delay_txt_class; ?>"><?= number_format($total_stock); ?> PCS</td>
                    <td class="text-center">
                        <?php
                        echo $delay_icon;
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>