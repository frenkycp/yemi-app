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
    'page_title' => 'Temperature Over (Total Frequency)',
    'tab_title' => 'Temperature Over (Total Frequency)',
    'breadcrumbs_title' => 'Temperature Over (Total Frequency)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    //.container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

    .temp-tbl{
        border:1px solid #3a3a3a;
        border-top: 0;
    }
    .temp-tbl > thead > tr > th{
        font-weight: normal;
        border:1px solid #3a3a3a;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 1.5em;
        border-bottom: 7px solid #3a3a3a;
        vertical-align: middle;
    }
    .temp-tbl > tbody > tr > td{
        border:1px solid #3a3a3a;
        font-size: 1.3em;
        background-color: #000;
        //font-weight: 1000;
        //color: rgba(255, 235, 59, 1);
        color: white;
        vertical-align: middle;
    }

");

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
    'action' => Url::to(['temperature-over']),
]); ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'absolute_or_reference')->dropDownList([
            'ABSOLUTE' => 'ABSOLUTE',
            'REFERENCE' => 'REFERENCE'
        ], [
            'onchange' => 'if($(this).val() == "REFERENCE"){
                $("#wh-prod").hide();
            } else {
                $("#wh-prod").show();
            }'
        ]); ?>
    </div>
    <div class="col-md-3" id="wh-prod">
        <?= $form->field($model, 'production_or_warehouse')->dropDownList([
            'PRODUCTION' => 'PRODUCTION',
            'WAREHOUSE' => 'WAREHOUSE'
        ]); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'period')->dropDownList(ArrayHelper::map(app\models\SensorLog::find()
        ->select('period')
        ->groupBy('period')
        ->orderBy('period DESC')
        ->all(), 'period', 'period')); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<table class="table table-bordered temp-tbl">
    <thead>
        <tr>
            <th>Area</th>
            <th class="text-center">Shift 1</th>
            <th class="text-center">Shift 2</th>
            <th class="text-center">Shift 3</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($tmp_tbl) > 0) {
            foreach ($tmp_tbl as $key => $value) {
                $freq_shift1 = $value->freq_shift1 == 0 ? '' : Html::a($value->freq_shift1, ['temperature-over-detail', 'map_no' => $value->map_no, 'period' => $model->period, 'shift' => 1, 'area' => $value->area, 'absolute' => $model->absolute_or_reference, 'category' => $model->production_or_warehouse], [
                    'class' => 'badge bg-red',
                    'style' => 'min-width: 50px; font-weight: normal; font-size: 16px;'
                ]);
                $freq_shift2 = $value->freq_shift2 == 0 ? '' : Html::a($value->freq_shift2, ['temperature-over-detail', 'map_no' => $value->map_no, 'period' => $model->period, 'shift' => 2, 'area' => $value->area, 'absolute' => $model->absolute_or_reference, 'category' => $model->production_or_warehouse], [
                    'class' => 'badge bg-red',
                    'style' => 'min-width: 50px; font-weight: normal; font-size: 16px;'
                ]);
                $freq_shift3 = $value->freq_shift3 == 0 ? '' : Html::a($value->freq_shift3, ['temperature-over-detail', 'map_no' => $value->map_no, 'period' => $model->period, 'shift' => 3, 'area' => $value->area, 'absolute' => $model->absolute_or_reference, 'category' => $model->production_or_warehouse], [
                    'class' => 'badge bg-red',
                    'style' => 'min-width: 50px; font-weight: normal; font-size: 16px;'
                ]);
                echo '<tr>
                    <td>' . $value->area . '</td>
                    <td class="text-center">' . $freq_shift1 . '</td>
                    <td class="text-center">' . $freq_shift2 . '</td>
                    <td class="text-center">' . $freq_shift3 . '</td>
                </tr>';
            }
            
        } else {
            echo '<tr>
                <td colspan="4">There is no temperature over on this period.</td>
            </tr>';
        }
        ?>
    </tbody>
</table>

