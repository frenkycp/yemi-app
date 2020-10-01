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
    'page_title' => 'Koyemi Max Capacity',
    'tab_title' => 'Koyemi Max Capacity',
    'breadcrumbs_title' => 'Koyemi Max Capacity'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');
$bg_url = Url::to('@web/uploads/ICON/coronavirus_03.png');

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
    //body, .content-wrapper {background-image: url('" . $bg_url . "');}
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
    #container-list {
        border: 1px solid gray;
        border-radius: 10px;
        padding: 5px 0px;
    }
    #img-title {
        border: 1px solid gray;
        border-radius: 10px;
        padding: 5px 0px;
        text-align: center;
    }
    #img-txt {
        font-size: 6em;
        letter-spacing: 1.5px;
    }
    .badge {
        font-size: 2em;
        margin: 5px;
    }
    #total-pengunjung {
        font-size: 20em;
        font-family: tahoma;
    }
    #detail-pengunjung {
        padding: 5px;
    }
    #list-pengunjung {
        padding-left: 20px;
        font-size: 1.5em;
        font-weight: bold;
    }
    #img-view {
        position: absolute;
        top: 10px;
    }
    .column {
        float: left;
        width: 50%;
    }

    /* Clear floats after the columns */
    .custom-row:after {
        content: '';
        display: table;
        clear: both;
    }
");

$script = "
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['koyemi-max-capacity-data', 'max_capacity' => $max_capacity]) . "',
            success: function(data){
                var tmp_data = JSON.parse(data);
                $('#total-pengunjung').html(tmp_data.current_capacity);
                $('#img-txt').html(tmp_data.msg);
                $('#img-view').attr('src', tmp_data.img_url);
                $('#img-title').attr('class', tmp_data.bg_class);
                
                $('#pengunjung-1').html('-');
                $('#pengunjung-2').html('-');
                $('#pengunjung-3').html('-');
                $('#pengunjung-4').html('-');
                $('#pengunjung-5').html('-');
                
                var tmp_count = 1;
                $.each(tmp_data.detail_pembeli , function(index, val) {
                    //alert(index);
                    $('#pengunjung-' + tmp_count).html(tmp_count + '. ' + val.full_name + ' (' + val.in + ')');
                    tmp_count = tmp_count + 1;
                });

            },
            complete: function(){
                setTimeout(function(){update_data();}, 1000);
            }
        });
    }

    function news() 
        {
            $.ajax
            ({ 
                url: '" . Url::to(['/display/indo-news']) . "',
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
                        <marquee scrollamount=\"25\" style=\"background-color: #61258e; color: white; text-align: center; font-size: 3em; letter-spacing: 5px; font-weight: normal; margin-bottom: 0.5em; position: fixed; z-index:2; right: 0; bottom: 0; left: 0; clear: both;\">
                            `+ tmp_str +`
                        </marquee> 
                    `);

                    setTimeout(function(){news();}, 180000);

                    // console.log(obj);
                }
            });
        };

    $(document).ready(function() {
        setupRefresh();
        update_data();
        news();
    });

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );
?>
<div class="row" style="background-color: #61258e;">
    <div class="col-md-12">
        <div class="text-center">
            <span id="today" style="color: white; font-size: 2em; font-weight: bold; letter-spacing: 2px; padding-left: 10px;">
                KOYEMI VISITOR
            </span>
        </div>
    </div>
</div>
<div style="margin: auto; width: 900px;">
    <div class="row" style="margin: 10px;">
        <div class="col-sm-12">
            <div id="img-title" class="bg-green">
                <span id="img-txt"><?= $data['msg']; ?></span><?= Html::img($data['img_url'], [
                'height' => '110px',
                'id' => 'img-view'
            ]); ?>
            </div>
            <div class="panel panel-primary" style="margin-top: 5px;">
                <div class="panel-heading text-center" style="background-color: #61258e;">
                    <h3 class="panel-title" style="font-size: 2em;">TOTAL PEMBELI</h3>
                </div>
                <div class="panel-body no-padding">
                    <div class="custom-row" style="height: 400px; padding: 5px;">
                        <div class="column text-center" style="height: 100%; border-right: 2px solid grey;">
                            <span id="total-pengunjung"><?= $data['current_capacity']; ?></span>
                        </div>
                        <div class="column" style="height: 100%;">
                            <div id="detail-pengunjung" class="text-left">
                                <div id="list-pengunjung">
                                    <span id="pengunjung-1">-</span><br/>
                                    <span id="pengunjung-2">-</span><br/>
                                    <span id="pengunjung-3">-</span><br/>
                                    <span id="pengunjung-4">-</span><br/>
                                    <span id="pengunjung-5">-</span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="berita"></div>