<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    'page_title' => null,
    'tab_title' => 'Toilet Status',
    'breadcrumbs_title' => 'Toilet Status'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center; padding: 0px !important;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    //body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        //width: 50%;
    }
    .toilet-container {border: 1px solid white; border-radius: 20px;}
    .toilet-text {font-size: 3em; padding: 0px 25px; background-color: rgba(0, 0, 0, 0.8); border-radius: 25px; letter-spacing: 5px;}
    .stopwatch-container {border-radius: 5px; margin: 0px 20px; font-size: 11em; color: white; letter-spacing: 3px;}
    #marquee-container {color: #333333; font-size: 5.5em; margin-top: 0.5em; font-weight: bold; letter-spacing: 7px; position: fixed;
                z-index:2;
                right: 0;
                bottom: 0;
                left: 0;
                padding: 0.4% 0% 0.5% 0%;
                text-align: center;
                clear: both;
}
");

$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['toilet-status-data']) . "',
            success: function(data){
                $.each(data , function(index, val) {
                    //alert(val.room_id);
                    //alert('text-' + val.room_id);
                    if(val.room_value == '0') {
                        $('#text-' + val.room_id).html('VACANT');
                        $('#container-' + val.room_id).attr('class', 'center bg-green');
                        //$('#stopwatch-' + val.room_id).hide();
                        $('#stopwatch-' + val.room_id).html('&nbsp;');
                    } else {
                        $('#text-' + val.room_id).html('OCCUPIED');
                        $('#container-' + val.room_id).attr('class', 'center bg-red');
                        //$('#stopwatch-' + val.room_id).show();
                        $('#stopwatch-' + val.room_id).html(val.stopwatch);
                    }
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

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );
?>
<div class="row" style="margin-top: 2.5em;">
    <?php
    foreach ($data as $key => $value) {
        $gender_code = substr($value['room_id'], 2, 2);

        if ($gender_code == '01') {
            $img_str = '@web/uploads/ICON/toilet_03_m.png';
        } else {
            $img_str = '@web/uploads/ICON/toilet_03_f.png';
        }

        if ($value['room_value'] == 0) {
            $container_class = 'center bg-green';
            $toilet_text = 'VACANT';
        } else {
            $container_class = 'center bg-red';
            $toilet_text = 'OCCUPIED';
        }
        ?>
        <div class="col-md-3">
            <div id="container-<?= $value['room_id']; ?>" class="<?= $container_class; ?>" style="width: 400px; border-radius: 20px;">
                <br/>
                <?= Html::img($img_str, ['alt' => 'My logo', 'class' => 'img-responsive pad center']); ?>
                <br/>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <span id="text-<?= $value['room_id']; ?>" class="toilet-text"><?= $toilet_text; ?></span>
                    </div>
                </div>
                <br/>
            </div>
            <div id="stopwatch-<?= $value['room_id']; ?>" class="stopwatch-container text-center">
                &nbsp;
            </div>
        </div>
        
    <?php }
    ?>
</div>

<div id="marquee-container">
    <marquee behavior="alternate" scrollamount="12" style="background-color: #61258e; color: darkgray;">Keep Clean & Dry !  <span class="japanesse" style="color: darkgray;">清潔第一</span>！</marquee>
</div>