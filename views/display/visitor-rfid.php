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
    'tab_title' => 'Visitor RFID Input',
    'breadcrumbs_title' => 'Visitor RFID Input'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: #FFF; border-color: #FFF !important;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header, h1 {color: white;}
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
    .div-center {
        position: absolute;
        top:0;
        bottom: 0;
        left: 0;
        right: 0;
        
        margin: auto;
        text-align: center;
    }
");

//$this->registerCssFile('@web/adminty_assets/css/bootstrap.min.css');
//$this->registerCssFile('@web/adminty_assets/css/component.css');
//$this->registerCssFile('@web/adminty_assets/css/style.css');
/*echo '<pre>';
print_r($vms_data);
echo '</pre>';*/

?>

<div class="div-center" style="width: 500px; height: 600px;">
    <h1>Please tap your RFID card ...</h1>
    <br/>
    <?= Html::img('@web/uploads/ICON/rfid_01.png', [
        //'style' => 'width: 100px;'
    ]); ?>

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        //'layout' => 'horizontal',
        'action' => Url::to(['visitor-rfid']),
    ]); ?>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'rfid_no', [
            'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control text-center'],
        ])->textInput()->label(false); ?>
        </div>
    </div>
    <span style="color: white;"><?= $visitor_name; ?></span>

    <!--<div class="alert alert-danger alert-dismissible text-left" style="<?= $is_alert == 0 ? 'display: none;' : ''; ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Alert!</h4>
        <?= $alert_msg; ?>
    </div>-->


    <?php ActiveForm::end(); ?>
</div>

