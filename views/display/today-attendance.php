<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Production\'s Attendance <span class="japanesse light-green"></span>',
    'tab_title' => 'Production\'s Attendance',
    'breadcrumbs_title' => 'Production\'s Attendance'
];
$color = 'ForestGreen';

$this->registerCss("
    .control-label {color: white;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .clinic-container {border: 1px solid white; border-radius: 10px; padding: 5px 20px;}

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        font-size: 2.5em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 100px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .description {font-size: 2.2em; padding-left: 10px;}
    .text-red{color: #ff1c00 !important; font-weight: bold;}
");

//$this->registerCssFile('@web/css/responsive.css');

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['today-attendance']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'post_date')->widget(DatePicker::classname(), [
            'options' => [
                'type' => DatePicker::TYPE_INPUT,
                'onchange'=>'this.form.submit()'
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label(false); ?>
        
    </div>
</div>

<?php ActiveForm::end(); ?>
<table class="table">
    <thead>
        <tr>
            <th>Location</th>
            <th class="text-center">MP Total</th>
            <th class="text-center">Balance</th>
            <th class="text-center">MP<br/>(Shift 1)</th>
            <th class="text-center">MP<br/>(Shift 2)</th>
            <th class="text-center">MP<br/>(Shift 3)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $key => $value): ?>
            <?php
            $balance = $value['actual'] - $value['plan'];
            ?>
            <tr>
                <td><?= $key; ?></td>
                <td class="text-center"><?= number_format($value['actual']) . ' <span style="font-size: 0.5em; color: gray;">of</span> ' . number_format($value['plan']); ?></td>
                <td class="text-center<?= $balance != 0 ? ' text-red' : ' text-green'; ?>"><?= Html::a(number_format($balance), ['today-attendance-detail', 'child_analyst' => $value['key'], 'post_date' => $model->post_date], ['target' => '_blank']); ?></td>
                <td class="text-center"><?= $data_by_shift[$value['key']]['1'] == 0 ? '' : number_format($data_by_shift[$value['key']]['1']); ?></td>
                <td class="text-center"><?= $data_by_shift[$value['key']]['2'] == 0 ? '' : number_format($data_by_shift[$value['key']]['2']); ?></td>
                <td class="text-center"><?= $data_by_shift[$value['key']]['3'] == 0 ? '' : number_format($data_by_shift[$value['key']]['3']); ?></td>
                
            </tr>
        <?php endforeach ?>
    </tbody>
</table>