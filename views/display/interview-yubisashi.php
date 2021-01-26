<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Interview Yubisashi Kosou <span class="japanesse light-green"></span>',
    'tab_title' => 'Interview Yubisashi Kosou',
    'breadcrumbs_title' => 'Interview Yubisashi Kosou'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

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
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //#summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {
        font-size : 1.5em;
        font-weight: bold;
    }
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

function getIcon($val){
    if ($val == 0) {
        return '⨯';
    } elseif ($val == 1) {
        return '&#9651;';
    } elseif ($val == 2) {
        return '<i class="fa fa-circle-o"></i>';
    } else {
        return '';
    }
}

/*echo '<pre>';
print_r($period_arr);
echo '</pre>';*/

//echo Yii::$app->request->baseUrl;
?>

<div style="font-size: 24px;"><b><u>Interview Yubisashi Kosou</u></b></div>
<br/>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['interview-yubisashi']),
]); ?>
<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'fiscal_year')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
            'prompt' => 'Choose Fiscal Year...',
        ]); ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'section')->dropDownList(ArrayHelper::map(app\models\SunfishViewEmp::find()->select('cost_center_code, cost_center_name')->groupBy('cost_center_code, cost_center_name')->orderBy('cost_center_name')->all(), 'cost_center_code', 'cost_center_name'), [
            'prompt' => 'Choose Section...',
        ]); ?>
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
            <th class="text-center" width="60px">No.</th>
            <th class="">Nama</th>
            <th class="text-center" width="12%">Yamaha Diamond</th>
            <th class="text-center" width="12%">12 Aturan Keselamatan & Kesehatan Kerja Yamaha</th>
            <th class="text-center" width="12%">Slogan Kualitas</th>
            <th class="text-center" width="12%">6 Pasal keselamatan lalu lintas Yamaha</th>
            <th class="text-center" width="12%">10 Komitmen berkendara</th>
            <th class="text-center" width="12%">Budaya Kerja YEMI</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($data) > 0) {
            $no = 0;
            foreach ($data as $value) {
                $no++;
                ?>
                <tr>
                    <td class="text-center"><?= $no; ?></td>
                    <td class=""><?= $value->EMP_NAME; ?></td>
                    <td class="text-center icon-status"><?= getIcon($value->YAMAHA_DIAMOND); ?></td>
                    <td class="text-center icon-status"><?= getIcon($value->K3); ?></td>
                    <td class="text-center icon-status"><?= getIcon($value->SLOGAN_KUALITAS); ?></td>
                    <td class="text-center icon-status"><?= getIcon($value->KESELAMATAN_LALU_LINTAS); ?></td>
                    <td class="text-center icon-status"><?= getIcon($value->KOMITMENT_BERKENDARA); ?></td>
                    <td class="text-center icon-status"><?= getIcon($value->BUDAYA_KERJA); ?></td>
                </tr>
            <?php }
        }
        ?>
    </tbody>
</table>