<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'Pallet Transporter Gedung ' . $fa .'<span class="japanesse text-green"></span>',
    'tab_title' => 'Pallet Transporter Gedung ' . $fa .'',
    'breadcrumbs_title' => 'Pallet Transporter Gedung ' . $fa .''
];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 30000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data2);
echo '</pre>';*/

?>
<div class="">
    <?php
    foreach ($line_data as $key => $value) {
        $status = $value['status'];
        $line = $value['user'];
        if ($status == 0) {
            $btn_class = 'btn btn-success text-center btn-block disabled';
            $link = '#';
        } elseif ($status == 1) {
            $btn_class = 'btn btn-danger text-center btn-block';
            $link = ['pallet-transporter/process', 'line' => $line, 'current_status' => $status];
        } else {
            $btn_class = 'btn btn-warning text-center btn-block';
        }

        if ($fa == 1) {
            $col_class = 'col-md-2';
        } else {
            $col_class = 'col-md-3';
        }
        echo '<div class="row" style="padding-bottom: 10px;"><div class="col-md-12">';
        echo Html::a($line, $link, ['class' => $btn_class, 'style' => 'font-size: 20px; line-height: 40px;']);
        echo '</div></div>';
    }
    ?>
</div>