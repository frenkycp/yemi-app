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
    'page_title' => '一人当たりの残業進捗 (Progress overtime hours per man) H-1',
    'tab_title' => '一人当たりの残業進捗 (Progress overtime hours per man) H-1',
    'breadcrumbs_title' => '一人当たりの残業進捗 (Progress overtime hours per man) H-1'
];

//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCssFile('@web/css/component.css');
$this->registerJsFile('@web/js/snap.svg-min.js');
$this->registerJsFile('@web/js/classie.js');
$this->registerJsFile('@web/js/svgLoader.js');

$css_string = "
    //.form-control, .control-label {background-color: #FFF; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.4em; text-align: center;}
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
        font-size: 12px;
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
        font-size: 14px;
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

/*$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#myTable').DataTable({
        'pageLength': 15,
        'order': [[ 0, 'desc' ]]
    });
});");*/

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
$grand_total_hours = 0;
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['progress-overtime-hours']),
]); ?>
<div class="row" style="display: none;">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->textInput(); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>

<div class="row" style="margin-top: 5px;">
    <div class="col-sm-6">
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th>Section</th>
                    <th class="text-center">Total Hours</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tmp_attendance as $key => $value):
                    $total_hours = round(($value->total_ot / 60));
                    $grand_total_hours += $total_hours;
                    ?>
                    <tr>
                        <td><?= $value->cost_center; ?></td>
                        <td><?= number_format($total_hours); ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th class="text-center" style="font-size: 2em;">Total Overtime<br/>(A)</th>
                    <th class="text-center" style="font-size: 2em;">Total MP<br/>(B)</th>
                    <th class="text-center" style="font-size: 2em;">Hours per MP<br/>(A/B)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" style="font-size: 4em;"><?= number_format($grand_total_hours); ?></td>
                    <td class="text-center" style="font-size: 4em;"><?= number_format($total_mp); ?></td>
                    <td class="text-center" style="font-size: 4em;"><?= number_format($grand_total_hours / $total_mp); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>