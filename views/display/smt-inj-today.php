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
    td {vertical-align: middle !important; height: 120px;}
    .target, .actual {font-size: 4em; font-weight: bold;}
    //.actual {font-size: 4em; font-weight:bold;}
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
    },1000);

JS;
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data_losstime);
echo '</pre>';*/

$img_class = $spr_txt_class = '';
if ($spr_aoi >= 97) {
    $spr_txt_class = ' text-green';
    $img_link = '@web/uploads/ICON/success.png';
} elseif ($spr_aoi >= 95 && $spr_aoi < 97) {
    $img_link = '@web/uploads/ICON/warning1.png';
    $img_class = 'blinked';
    $spr_txt_class = ' text-yellow';
} else {
    $img_link = '@web/uploads/ICON/danger.png';
    $img_class = 'blinked';
    $spr_txt_class = ' text-danger';
}

$target_delay = 500;
$target_stock = 2000;

?>
<div class="panel panel-success">
    <div class="panel-body">
        <table class="table table-responsive table-bordered table-striped">
            <tr style="font-size: 3em;" class="bg-light-blue color-palette">
                <th></th>
                <th class="text-center">TARGET</th>
                <th class="text-center">ACTUAL</th>
                <th class="text-center">STATUS</th>
            </tr>
            <tr>
                <td style="font-size: 2em;">SPR (AOI)</td>
                <td class="text-center target">99.5%</td>
                <td class="text-center actual<?= $spr_txt_class; ?>"><?= $spr_aoi; ?>%</td>
                <td class="text-center">
                    <?php
                    echo Html::img($img_link, ['width' => '100', 'class' => $img_class]);
                    ?>
                </td>
            </tr>
            <tr>
                <td style="font-size: 2em;">INTERNAL SETUP</td>
                <td class="text-center target">10%</td>
                <td class="text-center actual"><?= $dandori_pct; ?>%</td>
                <td class="text-center"></td>
            </tr>
            <tr>
                <td style="font-size: 2em;">DELAY PRODUCTION</td>
                <td class="text-center target"><<?= number_format($target_delay); ?> PCS</td>
                <td class="text-center actual"><?= number_format($total_delay); ?> PCS</td>
                <td class="text-center"></td>
            </tr>
            <tr>
                <td style="font-size: 2em;">STOCK WIP</td>
                <td class="text-center target"><<?= number_format($target_stock); ?> PCS</td>
                <td class="text-center actual"><?= number_format($total_stock); ?> PCS</td>
                <td class="text-center"></td>
            </tr>
        </table>
    </div>
</div>