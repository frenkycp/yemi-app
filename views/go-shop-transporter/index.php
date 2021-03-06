<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\SernoSlipLog2;

$this->title = [
    'page_title' => 'GO-SHOP Transporter (Factory ' . $fa .')</span>',
    'tab_title' => 'GO-SHOP Transporter (Factory ' . $fa .')',
    'breadcrumbs_title' => 'GO-SHOP Transporter (Factory ' . $fa .')'
];

$this->registerCss("
    ");

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
        $status = $value['status2'];
        $line = $value['user'];
        $nik = \Yii::$app->user->identity->username;

        $log = SernoSlipLog2::find()
        ->where([
            'line' => $line,
            'nik' => $nik,
        ])
        ->andWHere('arrival_time IS NULL')
        ->one();

        $data = [];
        if ($log !== null) {
            $btn_class = 'btn btn-warning text-center btn-block';
            $link = ['go-shop-transporter/process-arrival', 'line' => $line, 'nik' => $nik];
            $line .= ' (Arrival)';
            $data = [
                'confirm' => 'Are you sure to finish order from Line ' . $line . ' ?',
                'method' => 'post',
            ];
        } else {
            if ($status == 0) {
                $btn_class = 'btn btn-success text-center btn-block disabled';
                $link = '#';
            } elseif ($status == 1) {
                $btn_class = 'btn btn-danger text-center btn-block';
                if ($driver_status == 1) {
                    $btn_class .= ' disabled';
                }
                $link = ['go-shop-transporter/process', 'line' => $line, 'current_status' => $status];
                $data = [
                    'confirm' => 'Are you sure to pick order from Line ' . $line . ' ?',
                    'method' => 'post',
                ];
            } else {
                $btn_class = 'btn btn-warning text-center btn-block';
            }
        }

        if ($fa == 1) {
            $col_class = 'col-md-2';
        } else {
            $col_class = 'col-md-3';
        }

        echo '<div class="row" style="padding-bottom: 10px;"><div class="col-md-12">';
        echo Html::a($line, $link, ['class' => $btn_class, 'style' => 'font-size: 20px; line-height: 40px;', 'data' => $data]);
        echo '</div></div>';
    }
    ?>
</div>