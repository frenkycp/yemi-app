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
    'page_title' => 'Kadouritsu <span class="japanesse light-green"></span>',
    'tab_title' => 'Kadouritsu',
    'breadcrumbs_title' => 'Kadouritsu'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    //.form-control, .control-label {background-color: #FFF; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center; display: none;}
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
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: white;
        color: black;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
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
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: white;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
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
// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_data_arr);
echo '</pre>';*/
?>
<br/>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['ijazah-progress']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'fiscal_year')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
                //'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
    
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>

<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="text-center">KGI</th>
            <th class="text-center">KPI</th>
            <?php foreach ($period_arr as $period_val): ?>
                <th class="text-center" width="100px"><?= date('M\'y', strtotime($period_val . '01')); ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $child_analyst => $data_val): ?>
            <tr>
                <td rowspan="2"><?= $data_val['loc_desc']; ?></td>
                <td>Kadouritsu (%)</td>
                <?php foreach ($data_val['kadouritsu'] as $key => $kadouritsu_val): ?>
                    <td class="text-center"><?= $kadouritsu_val; ?></td>
                <?php endforeach ?>
            </tr>
            <tr>
                <td>Ratio Dandori (%)</td>
                <?php foreach ($data_val['dandori'] as $key => $dandori_val): ?>
                    <td class="text-center"><?= $dandori_val; ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>