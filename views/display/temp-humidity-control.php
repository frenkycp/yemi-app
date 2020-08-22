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

if ($_GET['category'] == 4 || $_GET['category'] == 5) {
    $this->registerCss("
        .container {width: auto;}
        .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; color: white;}
        body, .content-wrapper {background-color: #000;}
        .temp-widget {border-radius: 4px; overflow: auto; border: 1px solid white; font-size: 1.4em; width: 90px; letter-spacing: 1.1px;}
        .temp-widget-info {border-radius: 4px; overflow: auto; border: 1px solid white; font-size: 1.8em; width: 423px; letter-spacing: 1.1px;}
        .temp-widget-refrigerator {border-radius: 15px 15px 0px 0px; overflow: auto; border: 1px solid white; font-size: 0.75em; width: 25px; letter-spacing: 1.1px;}
        #main-body {overflow: auto;}
        .temp-widget-rh {border-radius: 4px; overflow: auto; border: 1px solid white; font-size: 0.75em; width: 35px; letter-spacing: 1px;}
        #custom-title {position: absolute; top: 40px; left: 40px; font-size: 1.5em; border: 1px solid black; border-radius: 5px; padding: 10px; background-color: rgba(0, 255, 0, 0.4);}
    ");
} else {
    $this->registerCss("
        .container {width: auto;}
        .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; color: white;}
        body, .content-wrapper {background-color: #000;}
        .temp-widget {border-radius: 4px; overflow: auto; border: 1px solid white; font-size: 0.75em; width: 25px; letter-spacing: 1.1px;}
        .temp-widget-refrigerator {border-radius: 15px 15px 0px 0px; overflow: auto; border: 1px solid white; font-size: 0.75em; width: 25px; letter-spacing: 1.1px;}
        #main-body {overflow: auto;}
        #custom-title {position: absolute; top: 40px; left: 40px; font-size: 1.5em; border: 1px solid black; border-radius: 5px; padding: 10px; background-color: rgba(0, 255, 0, 0.4);}
    ");
}


$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 6000000); // milliseconds
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
    <?= Html::img('@web/uploads/MAP/suhu_humidity_map.jpg', ['alt' => 'My logo', 'style' => 'opacity: 0.8', 'width' => '1600px']); ?>
    <?php
    $total_kwh = 0;
    foreach ($data as $key => $value) {
        $temp_class = ' bg-green-active';
        $total_kwh += round($value->kw);
        if ($category == 1) {
            //$params_val = $value->temparature . '&deg;';
            $params_val = $value->temparature;
            if ($value->map_no == 17 || $value->map_no == 18) {
                if ($params_val < $value->temp_min){
                    $temp_class = ' bg-red-active';
                }
            } else {
                if ($params_val > $value->temp_max) {
                    $temp_class = ' bg-red-active';
                }
            }
            /*if ($params_val < $value->temp_min || $params_val > $value->temp_max) {
                $temp_class = ' bg-red-active';
            }*/
        } elseif ($category == 2) {
            //$params_val = $value->humidity . '<small>%</small>';
            $params_val = $value->humidity;
            if ($params_val < $value->humi_min || $params_val > $value->humi_max) {
                $temp_class = ' bg-red-active';
            }
        } elseif ($category == 3) {
            //$params_val = $value->humidity . '<small>%</small>';
            $params_val = $value->noise;
            if ($params_val > $value->noise_max) {
                $temp_class = ' bg-red-active';
            }
        } elseif ($category == 4) {
            //$params_val = $value->humidity . '<small>%</small>';
            $params_val = round($value->power_consumption);
            
            if ($params_val > $value->power_max) {
                $temp_class = ' bg-red-active';
            }
        } elseif ($category == 5) {
            //$params_val = $value->humidity . '<small>%</small>';
            $params_val = round($value->pressure, 1);
            if ($params_val < $value->pressure_min || $params_val > $value->pressure_max) {
                $temp_class = ' bg-red-active';
            }
        }

        $widget_class = 'temp-widget';
        if ($value->is_refrigerator == 1) {
            $widget_class = 'temp-widget-refrigerator';
        }

        $content = '<div class="' . $widget_class . ' text-center' . $temp_class . '" style="position: absolute; top: ' . $value->top_pos . 'px; left: ' . $value->left_pos . 'px;"><div style="padding: 0px 4px;">' . $params_val . '</div></div>';
        if ($category == 3) {
            echo $params_val == null ? '' : Html::a($content, ['noise-chart', 'map_no' => $value->map_no], ['title' => strtoupper($value->area)]);
        } elseif ($category == 4) {
            $content = '<div class="' . $widget_class . ' text-center' . $temp_class . '" style="position: absolute; top: ' . $value->top_pos . 'px; left: ' . $value->left_pos . 'px;"><div style="padding: 0px 4px; border-bottom: 1px solid white;">' . $params_val . '%</div><div style="padding: 0px 4px;">' . $value->kw . ' kw</div></div>';
            echo $params_val == null ? '' : Html::a($content, ['power-consumption-chart', 'map_no' => $value->map_no], ['title' => strtoupper($value->area)]);
            if ($value->map_no == 44) {
                $tmp_temperature = app\models\SensorTbl::findOne(41);
                $temparature_class = ' bg-green-active';
                if ($tmp_temperature->temparature > $tmp_temperature->temp_max) {
                    $temparature_class = ' bg-red-active';
                }

                $content_temp = '<div class="' . $widget_class . ' text-center' . $temparature_class . '" style="position: absolute; top: ' . $value->top_pos . 'px; left: ' . ($value->left_pos - 90) . 'px;"><div style="padding: 0px 4px;">' . $tmp_temperature->temparature . '&deg; C</div></div>';
                echo $params_val == null ? '' : Html::a($content_temp, ['power-consumption-chart', 'map_no' => 41], ['title' => strtoupper($value->area)]);
            }
        } elseif ($category == 5) {
            $content = '<div class="' . $widget_class . ' text-center' . $temp_class . '" style="position: absolute; top: ' . $value->top_pos . 'px; left: ' . $value->left_pos . 'px;"><div style="padding: 0px 4px;">' . $params_val . ' <span style="font-size: 0.6em;">bar</span></div></div>';
            if ($value->map_no == 47 || $value->map_no == 48) {
                echo Html::a($content, ['air-pressure-chart', 'map_no' => $value->map_no], ['title' => strtoupper($value->area)]);
            }
            if (in_array($value->map_no, [49, 50, 51, 52, 53, 54])) {
                $widget_class = 'temp-widget-rh';
                $temp_class = ' bg-light-blue-active';
                $content = '<div class="' . $widget_class . ' text-center' . $temp_class . '" style="position: absolute; top: ' . $value->top_pos . 'px; left: ' . $value->left_pos . 'px;"><div style="padding: 0px 4px;">' . $params_val . ' <span style="font-size: 0.6em;"></span></div></div>';
                echo Html::a($content, ['running-hour-chart', 'map_no' => $value->map_no], ['title' => strtoupper($value->area)]);
            }

            //echo $params_val == null ? '0' : Html::a($content, ['air-pressure-chart', 'map_no' => $value->map_no], ['title' => strtoupper($value->area)]);
        } else {
            echo $params_val == null ? '' : Html::a($content, ['temp-humidity-chart', 'map_no' => $value->map_no], ['title' => strtoupper($value->area)]);
        }
        
    }
    ?>
    <div id="custom-title" class="text-center"><?= $custom_title; ?></div>
    <div class="temp-widget-info bg-black-active" style="position: absolute; top: 770px; left: 302px; <?= $_GET['category'] == 4 ? '' : 'display: none;'; ?>">
        <table class="table table-bordered" style="margin-bottom: 0px;">
            <tbody>
                <tr>
                    <td>Total kwH</td>
                    <td class="text-center" style="font-size: 1.1em;"><?= number_format($total_kwh); ?></td>
                </tr>
                <tr>
                    <td>Emisi CO<sub>2</sub> (Ton)</td>
                    <td class="text-center" style="font-size: 1.1em;"><?= round(($total_kwh * 0.891 / 1000), 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>