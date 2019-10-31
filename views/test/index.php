<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'For Testing');
$this->params['breadcrumbs'][] = $this->title;
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}

    #clinic-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #clinic-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #858689;
        color: white;
        font-size: 22px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #clinic-tbl > tbody > tr > td{
        //border:1px solid #29B6F6;
        font-size: 16px;
        background-color: #B3E5FC;
        font-weight: 1000;
        color: #555;
        vertical-align: middle;
    }
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
");
?>

<?= Html::img('@web/uploads/FactoryMap_2.jpg'); ?>
<i class="fa fa-circle" style="color: #FF0000; font-size: 15px; position: absolute; top: 177px; left: 317px; text-shadow: 0 0 3px #FF0000, 0 0 5px #FF0000;"></i>
<i class="fa fa-circle" style="color: #00FF00; font-size: 15px; position: absolute; top: 187px; left: 568px; text-shadow: 0 0 3px #00FF00, 0 0 5px #00FF00;"></i>