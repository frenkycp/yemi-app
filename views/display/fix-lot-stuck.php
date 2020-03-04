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
    'page_title' => 'Fix Lot Stuck <span class="japanesse light-green"></span>',
    'tab_title' => 'Fix Lot Stuck',
    'breadcrumbs_title' => 'Fix Lot Stuck'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    //.control-label {color: white;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center;}
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
    .clinic-container {border: 1px solid white; border-radius: 10px; padding: 5px 20px;}
    th {vertical-align: middle !important;}
");

date_default_timezone_set('Asia/Jakarta');

$dropdown = ArrayHelper::map(app\models\MachineIotCurrent::find()->select(['kelompok', 'child_analyst'])->where(['child_analyst' => ['WW02', 'WP01', 'WU01']])->groupBy('kelompok, child_analyst')->orderBy('kelompok')->all(), 'kelompok', 'kelompok', 'location');
$dropdown['END'] = '--END PROCESS--';
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['fix-lot-stuck']),
]); ?>
<div class="panel panel-primary">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'lot_number')->textInput([
                    'style' => 'text-align: center;'
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'next_process')->dropDownList(
                    $dropdown,
                    [
                        'prompt' => '-- Select a group --',
                    ]
                )->label('Next Process'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('FIX', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top: 5px;']); ?>
            </div>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>