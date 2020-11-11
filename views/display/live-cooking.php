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
    'tab_title' => 'Live Cooking',
    'breadcrumbs_title' => 'Live Cooking'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .content-header {color: white; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; text-align: center;}
    //body {background-color: #ecf0f5;}
    body, .content-wrapper {background-color: yellow;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .content {padding: 0px;}
    .content-lc {
        margin: 20px 10px;
        border: 3px solid silver;
        border-radius: 10px;
        padding-bottom: 10px;
        min-height: 720px;
    }
    marquee span { 
        margin-right: 100%; 
    } 
    marquee p { 
        white-space:nowrap;
        margin-right: 1000px; 
    } 
");

$this->registerJs("
    function playAudio() 
    {
        // var audio = new Audio('annound.mp3');
        // audio.play();
        // x.play();
        var x = document.getElementById('myAudio');
        //x.play();
        // setTimeout(function(){playAudio();}, 45000);
    }
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['live-cooking-data', 'now' => $now]) . "',
            success: function(data){
                var tmp_data = JSON.parse(data);
                $('#remaining-qty').html(tmp_data.remaining_qty);
                $('#today').html(tmp_data.today);
                $('#this-time').html(tmp_data.this_time);
                if(tmp_data.diff_s > 15){
                    $('#pesan').hide();
                }
            },
            complete: function(){
                setTimeout(function(){update_data();}, 1000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
        playAudio();
    });
");

$script = "
    $(document).ready(function() {
        setupRefresh();
        news();
    });

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 3600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
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
                    <marquee scrollamount=\"25\" style=\"background-color: transparent; color: #0008ff; text-align: center; font-size: 4em; letter-spacing: 5px; font-weight: bold; margin-bottom: 0.5em; position: fixed; z-index:2; right: 0; bottom: 0; left: 0; clear: both;\">
                        `+ tmp_str +`
                    </marquee> 
                `);

                setTimeout(function(){news();}, 180000);

                // console.log(obj);
            }
        });
    };
";
$this->registerJs($script, View::POS_HEAD );

//$this->registerCssFile('@web/adminty_assets/css/bootstrap.min.css');
//$this->registerCssFile('@web/adminty_assets/css/component.css');
//$this->registerCssFile('@web/adminty_assets/css/style.css');
/*echo '<pre>';
print_r($vms_data);
echo '</pre>';*/
$audio_url = '';
if ($pesan['category'] == 1) {
    //$audio_url = Url::to('@web/uploads/AUDIO/okay-1.wav');
    $audio_url = Url::to('@web/uploads/AUDIO/success_01.mp3');
} elseif ($pesan['category'] == 2) {
    $audio_url = Url::to('@web/uploads/AUDIO/wrong_01.mp3');
}
//$audio_url = Url::to('@web/uploads/AUDIO/okay-1.wav');
$menu_arr = \Yii::$app->params['live_cooking_photo_arr'];
?>
<audio id="myAudio" src="<?= $audio_url; ?>" autoplay="autoplay" hidden="hidden"></audio>
<div class="row" style="background-color: #61258e;">
    <div class="col-md-12 text-center">
        <div class="pull-left">
            <span id="today" style="color: white; font-size: 7em; font-weight: bold; letter-spacing: 2px;">
                <?= $today_str; ?>
            </span>
        </div>
        <div class="pull-right">
            <span id="this-time" style="color: white; font-size: 7em; font-weight: bold; letter-spacing: 2px;">
                <?= strtoupper(date('H:i')); ?>
            </span>
        </div>
    </div>
</div>
<div class="row text-center">
    <div class="col-md-6">
        <div class="content-lc">
            <span style="font-size: 45vh; font-family: tahoma; font-weight: bold; color: #000;" id="remaining-qty"><?= $remaining_qty; ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-lc" style="border: 0px;">
            <div style="width: 100%; margin: auto; border-radius: 20px;" class="bg-black text-center">
                <span style="font-size: 7em; border-radius: 5px;"><?= strtoupper($today_menu_txt); ?></span>
            </div>
            
            <div class="" style="margin-top: 20px;">
                <?= Html::img('@web/uploads/IMAGES/' . $menu_arr[$today_menu_txt], [
                    'class' => '',
                    //'height' => '500px',
                    'width' => '100%',
                    'style' => 'border-radius: 10px; border: 5px solid white;'
                ]) ?>
            </div>
        </div>
        
    </div>
</div>
<div id="berita"></div>
<div class="row">
    <div class="col-md-12 text-center">
        <div style="margin: 0px 10px; border-radius: 20px;" class="<?= $pesan['category'] == 1 ? 'bg-green' : 'bg-red'; ?>">
            <span id="pesan" style="font-size: 3em; font-weight: bold; letter-spacing: 2px;" class="">
                <?= $pesan['data']; ?>
            </span>
        </div>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['live-cooking']),
]); ?>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'nik', [
            'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'style' => 'background-color: yellow; border-color: yellow; text-align: center; color: silver;']
        ])->textInput([
            'onkeyup' => 'this.value=this.value.toUpperCase()',
            'onfocusout' => 'this.value=this.value.toUpperCase()',
        ])->label(false); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>