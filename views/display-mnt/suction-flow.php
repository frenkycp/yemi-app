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

$this->title = [
    'page_title' => null,
    'tab_title' => 'Dust Collector Suction Flow',
    'breadcrumbs_title' => 'Dust Collector Suction Flow'
];

$this->registerCss("
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; color: white;}
    body, .content-wrapper {background-color: #000;}
    .temp-widget {border-radius: 4px; overflow: auto; border: 1px solid white; font-size: 2em; width: 100px; letter-spacing: 1.1px;}
    .temp-widget-refrigerator {border-radius: 15px 15px 0px 0px; overflow: auto; border: 1px solid white; font-size: 0.75em; width: 25px; letter-spacing: 1.1px;}
    #main-body {overflow: auto;}
    #custom-title {position: absolute; top: 40px; left: 40px; font-size: 1.5em; border: 1px solid black; border-radius: 5px; padding: 10px; background-color: rgba(0, 255, 0, 0.4);}
");


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
    <?= Html::img('@web/uploads/MAP/dust_collector_ww.jpg', ['alt' => 'My logo', 'style' => 'opacity: 0.8', 'width' => '1600px']); ?>

    <?php
    foreach ($data as $key => $value) {
        $temp_class = ' bg-green-active';
        $params_val = number_format($value->flow);

        $widget_class = 'temp-widget';

        $content = '<div class="' . $widget_class . ' text-center' . $temp_class . '" style="position: absolute; top: ' . $value->top_pos . 'px; left: ' . $value->left_pos . 'px;"><div style="padding: 0px 4px;">' . $params_val . '</div></div>';
        echo $params_val == null ? '' : Html::a($content, ['#'], ['title' => strtoupper($value->area)]);
        
    }
    ?>
    
    <div id="custom-title" class="text-center">Dust Collector Suction Flow</div>
</div>