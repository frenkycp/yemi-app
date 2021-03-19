<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use app\models\TraceItemScrap;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'Inflam Stock Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Inflam Stock Monitoring',
    'breadcrumbs_title' => 'Inflam Stock Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    //.form-control, .control-label {background-color: #FFF; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #FFF;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl-1 > tbody > tr > td{
        border:1px solid #777474;
        font-size: 26px;
        background: white;
        color: black;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl-1 > thead > tr > th{
        border:1px solid #777474 !important;
        background-color: rgb(255, 229, 153);
        color: black;
        font-size: 30px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .summary-tbl-2 > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: white;
        color: black;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl-2 > thead > tr > th{
        border:1px solid #777474 !important;
        background-color: rgb(255, 229, 153);
        color: black;
        font-size: 16px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: black !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl-1 > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 26px;
        background: silver;
        color: black;
        vertical-align: middle;
        letter-spacing: 1.1px;
        font-weight: bold;
        //height: 100px;
    }
    .subtitle {
        font-size: 30px;
    }
    .column-1 {width: 40%;}
    .column-2 {width: 30%;}
    .column-3 {width: 30%;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //#summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['inflam-stock']),
]); ?>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-4">
        <?= $form->field($model, 'location')->widget(Select2::classname(), [
            'data' => $location_arr,
            'options' => [
                'placeholder' => 'Choose Location...',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<span class="subtitle"><b>SUMMARY :</b></span>
<table class="table summary-tbl summary-tbl-1" style="">
    <thead>
        <tr>
            <th class="text-center" rowspan="2">
                Category
            </th>
            <th class="text-center" colspan="2">
                Total QTY
            </th>
        </tr>
        <tr>
            <th class="text-center">(KG)</th>
            <th class="text-center">(L)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_kg = $total_l = 0;
        if (count($data) > 0) { ?>
            <?php foreach ($data as $key => $value): 
                $total_kg += $value['kg'];
                $total_l += $value['l'];
                ?>
                <tr>
                    <td class="text-center"><?= $key; ?></td>
                    <td class="text-center"><?= number_format($value['kg']); ?></td>
                    <td class="text-center"><?= number_format($value['l']); ?></td>
                </tr>
            <?php endforeach ?>
            <tfoot>
                <tr>
                    <td class="text-center">TOTAL</td>
                    <td class="text-center"><?= number_format($total_kg); ?></td>
                    <td class="text-center"><?= number_format($total_l); ?></td>
                </tr>
            </tfoot>
        <?php } else { ?>
            <tr>
                <td colspan="3">
                    No data found...
                </td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>

<span class="subtitle"><b>DETAIL :</b></span>
<table class="table summary-tbl summary-tbl-2">
    <thead>
        <tr>
            <th class="text-center">Category</th>
            <th class="text-center">Part No.</th>
            <th class="">Description</th>
            
            <th class="text-center">UM</th>
            <th class="text-center">Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($detail_data) > 0) { ?>
            <?php foreach ($detail_data as $key => $value): ?>
                <tr>
                    <td class="text-center"><?= $value->SAFETY_CATEGORY_1; ?></td>
                    <td class="text-center"><?= $value->ITEM; ?></td>
                    <td class=""><?= $value->ITEM_DESC; ?></td>
                    
                    <td class="text-center"><?= $value->UM; ?></td>
                    <td class="text-center"><?= number_format($value->NILAI_INVENTORY); ?></td>
                </tr>
            <?php endforeach ?>
        <?php } else { ?>
            <tr>
                <td colspan="5">No data found...</td>
            </tr>
        <?php }
        ?>
        
    </tbody>
</table>