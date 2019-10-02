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
    'page_title' => null,
    'tab_title' => 'GO Sub Assy Tracking',
    'breadcrumbs_title' => 'GO Sub Assy Tracking'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

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
    h3, h5 {opacity: 0.9;}
    .location-container {padding: 0px 10px; border: 1px solid white; border-radius: 5px;}
    .station-header {display: block; border-bottom: 1px solid white; font-size: 2em; text-align: center; padding: 10px;}
    .station-body ul li {padding: 5px 0px; font-size: 1.2em;}
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      //setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['gosub-location-data']) . "',
            success: function(data){
                $.each(data.data , function(index, val) {
                    //alert(index);
                    $('#'+index).html(val);
                });
                $('.user-loc').remove();
                $.each(data.absolute_loc_arr , function(index, val) {
                    //alert(val.name);
                    $('#main-body').append('<img title=\"' + val.nik + ' [' + val.minor + '] [' + val.pos_x + ', ' + val.pos_y + '] - ' + val.name + ' (LAST UPDATE : ' + val.last_update + ' ago)\" class=\"user-image user-loc\" width=\"25px\" src=\"" . Url::to('@web/uploads/ICON/marker_08.png') . "\" style=\"position: absolute; top: ' + val.top + '; left: ' + val.left + '; opacity: 1;\"></img>');
                });
            },
            complete: function(){
                setTimeout(function(){update_data();}, 1000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
    });
");

/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<div id="main-body">
    <?= Html::img('@web/uploads/MAP/go_sub_map_crop2.png', ['alt' => 'My logo', 'height' => 900, 'style' => 'opacity: 0.8', 'style' => 'position: absolute; top: 0px; left: 0px;']); ?>
    
</div>

<div class="row" style="color: white; padding-top: 900px;">
    <div class="col-md-3">
        <div class="location-container">
            <div class="station-header">
                <span class="">STATION</span>
            </div>
            <div class="station-body" id="<?= strtolower($location_arr[0]) ?>">
                
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="location-container">
            <div class="station-header">
                <span class="">NETWORK ASSY</span>
            </div>
            <div class="station-body" id="<?= strtolower($location_arr[1]) ?>">
                
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="location-container">
            <div class="station-header">
                <span class="">FRONT GRILLE ASSY</span>
            </div>
            <div class="station-body" id="<?= strtolower($location_arr[2]) ?>">
                
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="location-container">
            <div class="station-header">
                <span class="">ACCESSORIES ASSY</span>
            </div>
            <div class="station-body" id="<?= strtolower($location_arr[3]) ?>">
                
            </div>
        </div>
    </div>
</div>