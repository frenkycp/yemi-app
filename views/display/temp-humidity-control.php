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

date_default_timezone_set('Asia/Jakarta');

$this->title = $title;
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; color: white;}
    body, .content-wrapper {background-color: #000;}
    .temp-widget {border-radius: 4px;}
");



$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 10000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['temp-humi-data', 'room_id' => $_GET['room_id']]) . "',
            success: function(data){
                var tmp_data = JSON.parse(data);
                $('#room-name').html(tmp_data.room_name);
                $('#todays-date').html(tmp_data.today);
                $('#meeting-content').html(tmp_data.meeting_content);
            },
            complete: function(){
                setTimeout(function(){update_data();}, 1000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
    });
");*/

/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div id="main-body">
    <?= Html::img('@web/uploads/MAP/suhu_humidity_map.jpg', ['alt' => 'My logo', 'style' => 'opacity: 0.8']); ?>
    <?php
    foreach ($data as $key => $value) {
        $temp_class = ' bg-green-active';
        if ($category == 1) {
            $params_val = $value->temparature . '&deg;';
            if ($params_val < $value->temp_min || $params_val > $value->temp_max) {
                $temp_class = ' bg-red-active';
            }
        } elseif ($category == 2) {
            $params_val = $value->humidity . '<small>%</small>';
            if ($params_val < $value->humi_min || $params_val > $value->humi_max) {
                $temp_class = ' bg-red-active';
            }
        }

        $content = '<div class="temp-widget text-center' . $temp_class . '" style="position: absolute; top: ' . $value->top_pos . 'px; left: ' . $value->left_pos . 'px;"><div style="padding: 1px 5px;">' . $params_val . '</div></div>';
        echo Html::a($content, ['temp-humidity-chart', 'map_no' => $value->map_no], ['title' => strtoupper($value->area)]);
    }
    ?>
</div>