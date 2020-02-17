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

//$this->registerCssFile('@web/adminty_assets/css/bootstrap.min.css');
//$this->registerCssFile('@web/adminty_assets/css/component.css');
//$this->registerCssFile('@web/adminty_assets/css/style.css');
/*echo '<pre>';
print_r($vms_data);
echo '</pre>';*/
$audio_url = '';
if ($pesan['category'] == 1) {
    $audio_url = Url::to('@web/uploads/AUDIO/okay-1.wav');
} elseif ($pesan['category'] == 2) {
    $audio_url = Url::to('@web/uploads/AUDIO/wrong_01.mp3');
}
$audio_url = Url::to('@web/uploads/AUDIO/okay-1.wav');
?>
<audio id="myAudio" src="<?= $audio_url; ?>" autoplay="autoplay" hidden="hidden"></audio>
<div class="row" style="background-color: #61258e;">
    <div class="col-md-12 text-center">
        <div class="pull-left">
            <span id="today" style="color: white; font-size: 7em; font-weight: bold; letter-spacing: 2px;">
                <?= strtoupper(date('l, j M\' Y', strtotime($today))); ?>
            </span>
        </div>
        <div class="pull-right">
            <span id="today" style="color: white; font-size: 7em; font-weight: bold; letter-spacing: 2px;">
                <?= strtoupper($today_menu_txt); ?>
            </span>
        </div>
    </div>
</div>
<div class="row text-center">
    <div class="col-md-12">
        <span style="font-size: 55vh; font-family: tahoma; font-weight: bold; color: #000;" id="remaining-qty"><?= $remaining_qty; ?></span>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['live-cooking']),
]); ?>

<div class="row">
    <div class="col-md-12 text-center">
        <span id="pesan" style="font-size: 2em;" class="<?= $pesan['category'] == 1 ? 'text-green' : 'text-red'; ?>">
            <?= $pesan['data']; ?>
        </span>
    </div>
</div>
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