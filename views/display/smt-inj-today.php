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
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
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
    .pct {font-size: 0.5em;}
    .row-title {font-size: 3.5em !important; padding-left: 20px !important;}
    .text-red{color: #ff1c00 !important;}
");

//$this->registerCssFile('@web/css/responsive.css');

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 30000); // milliseconds
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

/*$img_class = $spr_txt_class = '';
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
}*/

foreach ($dandori_pct as $key => $value) {
    
    if ($value > 10) {
        $dandori_txt_class[] = ' text-danger';
        $dandori_icon[] = '<i class="fa fa-close text-red icon-status blinked"></i>';
    } else {
        $dandori_txt_class[] = ' text-green';
        $dandori_icon[] = '<i class="fa fa-circle-o text-green icon-status"></i>';
    }
}


$target_delay = 0;
$target_stock = 2000;
$title_txt = '';
if (strpos($location_str, 'SMT') !== false) {
    $title_txt = '<span style="font-size: 5em; color: white; font-weight: bold;">YEMI - SMT TODAY <span style="color: #60e418;" class="japanesse">(本日の塗装)</span></span>';
}
if (strpos($location_str, 'INJ') !== false) {
    $title_txt = '<span style="font-size: 5em; color: white; font-weight: bold;">YEMI - INJ TODAY <span style="color: #60e418;" class="japanesse">(本日のプラ成形)</span></span>';
}
?>
<?= $title_txt; ?>
<div class="row">
    <div class="col-md-12">
        <table id="smt-today" class="table table-responsive table-bordered">
            <thead>
                <tr style="font-size: 3em;" class="">
                    <th class="text-center" colspan="2"><?= $location_str; ?> <?= $line == '' ? '' : 'LINE ' . (int)$line ?></th>
                    <th class="text-center">TARGET</th>
                    <th class="text-center" width="400px">ACTUAL</th>
                    <th class="text-center" style="width: 200px;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <!--<tr style="display: none;">
                    <td style="font-size: 2em;" rowspan="2">SPR (AOI)</td>
                    <td class="text-center"><?= '';//strtoupper(date('d M \'y')); ?></td>
                    <td class="text-center target">99.5 %</td>
                    <td class="text-center actual<?= '';//$spr_txt_class[0]; ?>"><?= '';//$spr_aoi[0]; ?> %</td>
                    <td class="text-center" style="">
                        <?php
                        //echo $spr_icon[0];
                        //echo Html::img($img_link, ['width' => '100', 'class' => $img_class]);
                        ?>
                    </td>
                </tr>-->
                <tr style="display: none;">
                    <td class="text-center"><?= strtoupper(date('M \'y')); ?></td>
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
                    <td class="row-title" rowspan="2">Internal Setup<br/><span class="japanesse">(内段取り)</span></td>
                    <td class="text-center"><?= strtoupper(date('d M \'y')); ?></td>
                    <td class="text-center target">10 <span class="pct">%</span></td>
                    <td class="text-center actual<?= $dandori_txt_class[0]; ?>"><?= $dandori_pct[0]; ?> <span class="pct">%</span></td>
                    <td class="text-center">
                        <?php
                        echo $dandori_icon[0];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><?= strtoupper(date('M \'y')); ?></td>
                    <td class="text-center target">10 <span class="pct">%</span></td>
                    <td class="text-center actual<?= $dandori_txt_class[1]; ?>"><?= $dandori_pct[1]; ?> <span class="pct">%</span></td>
                    <td class="text-center" style="">
                        <?php
                        echo $dandori_icon[1];
                        //echo Html::img($img_link, ['width' => '100', 'class' => $img_class]);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="row-title">External Setup<br/><span class="japanesse">(外段取り)</span></td>
                    <td class="text-center">
                        <?php

                        if ($ext_dandori_current['parent_desc'] !== null) {
                            echo $ext_dandori_current['parent_desc'] . '<br/>(' . $ext_dandori_current['qty'] . ' <span style="font-size: 0.5em;">PCS</span>)';
                            $ext_dandori_stat = $ext_dandori_current['status'];
                        } else {
                            echo 'No Plan Today ...';
                            $ext_dandori_stat = '-';
                        }
                        ?>
                    </td>
                    <td class="text-center target">100 <span class="pct">%</span></td>
                    <td class="text-center actual">
                        <?php
                        $ext_dandori_icon = '<i class="fa fa-circle-o text-green icon-status"></i>';
                        if ($ext_dandori_stat === 0) {
                            echo '<span class="text-red">' . \Yii::$app->params['ext_dandori_status'][$ext_dandori_stat] . '</span>';
                            $ext_dandori_icon = '<i class="fa fa-close text-red icon-status blinked"></i>';
                        } elseif ($ext_dandori_stat === 1) {
                            echo '<span class="text-yellow">' . \Yii::$app->params['ext_dandori_status'][$ext_dandori_stat] . '</span>';
                            $ext_dandori_icon = '<i class="fa fa-warning text-yellow icon-status blinked"></i>';
                        } elseif ($ext_dandori_stat === 2) {
                            echo '<span class="text-yellow">' . \Yii::$app->params['ext_dandori_status'][$ext_dandori_stat] . '</span>';
                            $ext_dandori_icon = '<i class="fa fa-warning text-yellow icon-status blinked"></i>';
                        } elseif ($ext_dandori_stat === 3) {
                            echo '<span class="text-green">' . \Yii::$app->params['ext_dandori_status'][$ext_dandori_stat] . '</span>';
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        echo $ext_dandori_icon;
                        ?>
                    </td>
                </tr>
                <tr>
                    <?php
                    if ($prod_target_actual['balance'] < 0) {
                        $delay_txt_class = ' text-red';
                        $delay_icon = '<i class="fa fa-close icon-status blinked' . $delay_txt_class . '"></i>';
                    } else {
                        $delay_txt_class = ' text-green';
                        $delay_icon = '<i class="fa fa-circle-o icon-status' . $delay_txt_class . '"></i>';
                    }
                    ?>
                    <td class="row-title" colspan="2">PRODUCTION PROGRESS (N)<br/><span class="japanesse">対生産計画</span></td>
                    <td class="text-center target"><?= number_format($prod_target_actual['plan']); ?> <span style="font-size: 0.3em;">PCS</span></td>
                    <td class="text-center actual"><?= number_format($prod_target_actual['actual']); ?> <span style="font-size: 0.3em;">PCS</span></td>
                    <td class="text-center actual<?= $delay_txt_class; ?>"><?= number_format($prod_target_actual['balance']); ?> <span style="font-size: 0.3em;">PCS</span></td>
                </tr>
                <!--<tr>
                    <?php
                    /*if ($total_stock > $target_stock) {
                        $stock_txt_class = ' text-red';
                        $stock_icon = '<i class="fa fa-close icon-status blinked' . $stock_txt_class . '"></i>';
                    } else {
                        $stock_txt_class = ' text-green';
                        $stock_icon = '<i class="fa fa-circle-o icon-status' . $stock_txt_class . '"></i>';
                    }
                    ?>
                    <td class="row-title" colspan="2">Stock WIP<br/><span class="japanesse">(仕掛り在庫)</span></td>
                    <td class="text-center target"><?= number_format($target_stock); ?> <span style="font-size: 0.5em;">PCS</span></td>
                    <td class="text-center actual<?= $stock_txt_class; ?>"><?= number_format($total_stock); ?> <span style="font-size: 0.5em;">PCS</span></td>
                    <td class="text-center">
                        <?php
                        echo $stock_icon;*/
                        ?>
                    </td>
                </tr>-->
            </tbody>
        </table>
    </div>
</div>