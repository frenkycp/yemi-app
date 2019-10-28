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
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
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

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 25000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );
?>

<?php
foreach ($loc_arr as $key => $loc) {
    ?>
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= $loc; ?></h3>
            </div>
            <div class="panel-body" style="min-height: 600px;">
                <?php
                foreach ($data as $key => $value_beacon) {
                    if ($value_beacon['lokasi'] == $loc) {
                        //$date1 = new \DateTime();
                        $time_second = strtotime(date('Y-m-d H:i:s'));
                        $time_first = strtotime($value_beacon['start_date']);
                        $diff_seconds = $time_second - $time_first;
                        $diff_hours = round(($diff_seconds / 3600), 1);
                        $txt_class = ' text-green';
                        if ($diff_hours > 10) {
                            $txt_class = ' text-red';
                        }
                        echo '<i style="font-size: 3em; padding: 5px 15px;" class="fa fa-fw fa-cart-plus' . $txt_class . '" title="Lot number : ' . $value_beacon['lot_number'] . '&#010;Model : ' . $value_beacon['model_group'] . '&#010;Machine ID : ' . $value_beacon['mesin_id'] . '&#010;Machine Desc. : ' . $value_beacon['mesin_description'] . '&#010;Start Time : ' . date('Y-m-d H:i', strtotime($value_beacon['start_date'])) . '"></i>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php }
?>