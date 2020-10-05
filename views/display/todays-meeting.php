<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    //'page_title' => 'Machine Utility Rank (Daily) <span class="japanesse text-green"></span>',
    'page_title' => null,
    'tab_title' => 'Todays Meeting',
    'breadcrumbs_title' => 'Todays Meeting'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    //body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000; overflow-y: hidden;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .content {padding: 0px;}
    .table tr {border-collapse:separate; border-spacing:0 5px;}
    .table > tbody > tr > td {padding: 0px;}
    //tr:nth-child(even) {background-color: rgba(255, 255, 255, 0.15);}
    //tr:nth-child(odd) {background-color: rgba(255, 255, 255, 0.1);}
    marquee span { 
        margin-right: 100%; 
    } 
    marquee p { 
        white-space:nowrap;
        margin-right: 1000px; 
    } 
");
$this->registerCssFile('@web/css/component.css');
$this->registerJsFile('@web/js/snap.svg-min.js');
$this->registerJsFile('@web/js/classie.js');
$this->registerJsFile('@web/js/svgLoader.js');


if ($_GET['room_id'] == 6) {
    $this->registerJs("
        window.onload = setupRefresh;

        function setupRefresh() {
          setTimeout(\"refreshPage();\", 600000); // milliseconds
        }
        function refreshPage() {
           window.location = location.href;
        }

        function cek_tamu() 
        {
            $.ajax
            ({ 
                url: 'http://10.110.52.5:99/plus/display/visitor_coridor.php?cek&room_id=" . $_GET['room_id'] . "',
                success: function (result) 
                {
                    var json = result, 
                    //obj = JSON.parse(json);
                    obj = json;

                    console.log(obj);

                    if (obj.datang < 1.35 && obj.visitor_comp != null) 
                    {
                        window.location = 'http://10.110.52.5:99/plus/display/visitor_coridor.php?room_id=" . $_GET['room_id'] . "';
                    }
                    else
                    {
                        setTimeout(function(){cek_tamu();}, 1500);
                    }
                }
            });
        };
        function update_data(){
            $.ajax({
                type: 'POST',
                url: '" . Url::to(['todays-meeting-data', 'room_id' => $_GET['room_id']]) . "',
                success: function(data){
                    var tmp_data = JSON.parse(data);
                    $('#room-name').html(tmp_data.room_name);
                    $('#todays-date').html(tmp_data.today);
                    $('#meeting-content').html(tmp_data.meeting_content);
                },
                complete: function(){
                    setTimeout(function(){update_data();}, 3000);
                }
            });
        }
        function animation_page(){
            loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 700, easingIn : mina.easeinout } ); //------------------- ANIMASI -------------------------
            function init() //------------------- ANIMASI -------------------------
            { //------------------- ANIMASI -------------------------
                loader.show(); //------------------- ANIMASI -------------------------
                setTimeout( function() { loader.hide(); }, 700 ); //------------------- ANIMASI -------------------------
            } //------------------- ANIMASI -------------------------

            init(); //------------------- ANIMASI -------------------------
            //setInterval(animation_page, 5000);
        };
        $(document).ready(function() {
            update_data();
            cek_tamu();
            animation_page();
        });
    ");
} else {
    $this->registerJs("
        function update_data(){
            $.ajax({
                type: 'POST',
                url: '" . Url::to(['todays-meeting-data', 'room_id' => $_GET['room_id']]) . "',
                success: function(data){
                    var tmp_data = JSON.parse(data);
                    $('#room-name').html(tmp_data.room_name);
                    $('#todays-date').html(tmp_data.today);
                    $('#meeting-content').html(tmp_data.meeting_content);
                },
                complete: function(){
                    setTimeout(function(){update_data();}, 3000);
                }
            });
        }

        function animation_page(){
            loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 700, easingIn : mina.easeinout } ); //------------------- ANIMASI -------------------------
            function init() //------------------- ANIMASI -------------------------
            { //------------------- ANIMASI -------------------------
                loader.show(); //------------------- ANIMASI -------------------------
                setTimeout( function() { loader.hide(); }, 700 ); //------------------- ANIMASI -------------------------
            } //------------------- ANIMASI -------------------------

            init(); //------------------- ANIMASI -------------------------
            //setInterval(animation_page, 60000);
        };
        $(document).ready(function() {
            update_data();
            animation_page();
        });
        
    ");
}

if ($room_info->id == 6 || $room_info->id == 1) {
    $script = "
        $(document).ready(function() {
            setupRefresh();
            news();
        });

        function setupRefresh() {
          setTimeout(\"refreshPage();\", 180000); // milliseconds
        }
        function refreshPage() {
           window.location = location.href;
        }

        function news() 
        {
            $.ajax
            ({ 
                url: '" . Url::to(['japan-news']) . "',
                type: 'get',
                data: 
                {
                    'news':'on'
                },
                success: function (result) 
                {
                    var json = result, 
                    obj = JSON.parse(json);
                    var tmp_str = '';
                    $.each( obj.news, function( key, value ) {
                        //alert( key + ': ' + value );
                        if(tmp_str == ''){
                            tmp_str = value;
                        } else {
                            tmp_str += ' <span> </span> ' + value;
                        }
                    });

                    $('#berita').html(`
                        <marquee scrollamount=\"25\" style=\"background-color: transparent; color: white; text-align: center; font-size: 5em; letter-spacing: 5px; font-weight: normal; margin-bottom: 0.5em; position: fixed; z-index:2; right: 0; bottom: 0; left: 0; clear: both;\">
                            `+ tmp_str +`
                        </marquee> 
                    `);

                    setTimeout(function(){news();}, 180000);

                    // console.log(obj);
                }
            });
        };
    ";
} else {
    $script = "
        $(document).ready(function() {
            setupRefresh();
            news();
        });

        function setupRefresh() {
          setTimeout(\"refreshPage();\", 180000); // milliseconds
        }
        function refreshPage() {
           window.location = location.href;
        }

        function news() 
        {
            $.ajax
            ({ 
                url: '" . Url::to(['indo-news']) . "',
                type: 'get',
                data: 
                {
                    'news':'on'
                },
                success: function (result) 
                {
                    var json = result, 
                    obj = JSON.parse(json);
                    var tmp_str = '';
                    $.each( obj.news, function( key, value ) {
                        //alert( key + ': ' + value );
                        if(tmp_str == ''){
                            tmp_str = value;
                        } else {
                            tmp_str += ' <span> </span> ' + value;
                        }
                    });

                    $('#berita').html(`
                        <marquee scrollamount=\"25\" style=\"background-color: transparent; color: white; text-align: center; font-size: 5em; letter-spacing: 5px; font-weight: normal; margin-bottom: 0.5em; position: fixed; z-index:2; right: 0; bottom: 0; left: 0; clear: both;\">
                            `+ tmp_str +`
                        </marquee> 
                    `);

                    setTimeout(function(){news();}, 180000);

                    // console.log(obj);
                }
            });
        };
    ";
}

$this->registerJs($script, View::POS_HEAD );

//$this->registerCssFile('@web/adminty_assets/css/bootstrap.min.css');
//$this->registerCssFile('@web/adminty_assets/css/component.css');
//$this->registerCssFile('@web/adminty_assets/css/style.css');
/*echo '<pre>';
print_r($vms_data);
echo '</pre>';*/
?>
<div id="pagewrap" class="pagewrap">
    <div class="container show">
        <div class="row" style="background-color: #21005a; color: white; font-size: 7em; border-top: 1px solid white; border-bottom: 1px solid white; letter-spacing: 3px;">
            <div class="col-md-12">
                <span id="room-name">
                    <?php
                    $room_name = strtoupper($room_info->room_name);
                    if ($room_id == 1 || $room_id == 6) {
                        $room_name = strtoupper($room_info->room_name . ' ROOM');
                    }
                    echo $room_info->id == null ? '' : $room_name;
                    ?>
                </span>

                <span id="todays-date" class="pull-right">
                    <?= strtoupper(date('d M\' Y')) . ' <small style="color: #D58936;">' . date('H:i') . '</small>'; ?>
                </span>
            </div>
        </div>

        <br/>
        <div class="row">
            <div id="meeting-content" style="font-family: 'MS PGothic', Osaka, Arial, sans-serif; text-transform: uppercase;">
            </div>
        </div>
        <div id="berita"></div>
    </div>
    
    <div id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <!------------------- ANIMASI ------------------------->
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none" > <!------------------- ANIMASI ------------------------->
            <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/> <!------------------- ANIMASI ------------------------->
        </svg> <!------------------- ANIMASI ------------------------->
    </div>
</div>
