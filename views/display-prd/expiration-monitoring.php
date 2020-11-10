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
    'page_title' => 'Expired Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Expired Monitoring',
    'breadcrumbs_title' => 'Expired Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .badge {font-weight: normal;}

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 12px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: white !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: yellow;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #yesterday-tbl > tbody > tr > td{
        border:1px solid #777474;
        background: #000;
        color: #FFF;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 2px;
        //height: 100px;
    }
    #popup-tbl > tfoot > tr > td {
        font-weight: bold;
        background-color: rgba(0, 0, 150, 0.3);
    }
    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    .summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .bg-yellow-mod {background-color: yellow !important;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}
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
$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
        e.preventDefault();
        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");
$total_kwh = 0;

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['expiration-monitoring']),
]); ?>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-4">
        <?php echo '<label class="control-label">Select date range</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'from_date',
            'attribute2' => 'to_date',
            'options' => ['placeholder' => 'Start date'],
            'options2' => ['placeholder' => 'End date'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'item_category')->dropDownList(ArrayHelper::map(app\models\TraceItemDtr::find()->select('CATEGORY')->where('CATEGORY IS NOT NULL')->groupBy('CATEGORY')->orderBy('CATEGORY')->all(), 'CATEGORY', 'CATEGORY')); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="panel panel-default">
    <div class="panel-body no-padding">
        <?=
        Highcharts::widget([
            'scripts' => [
                'highcharts-more',
                //'modules/exporting',
                //'themes/sand-signika',
                'modules/solid-gauge',
                //'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'area',
                    'height' => '500',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'zoomType' => 'x'
                ],
                'title' => [
                    'text' => null,
                ],
                'xAxis' => [
                    'type' => 'datetime',
                    'lineWidth' => 1,
                ],
                'yAxis' => [
                    'minorGridLineWidth' => 0,
                    'title' => [
                        'enabled' => false
                    ],
                    'allowDecimals' => false,
                    //'max' => 1500,
                    'min' => 0,
                    //'tickInterval' => 20
                ],
                'legend' => [
                    'enabled' => false
                ],
                'credits' => [
                    'enabled' => false
                ],
                'tooltip' => [
                    'enabled' => true,
                    'valueSuffix' => ' Item(s)'
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'area' => [
                        'stacking' => 'percent',
                        'marker' => [
                            'enabled' => false
                        ],
                    ],
                    
                ],
                'series' => $data,
            ],
        ]);
        ?>
    </div>
</div>

<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="text-center">Action</th>
            <th class="text-center">Serial No.</th>
            <th class="text-center">Part No.</th>
            <th class="">Description</th>
            <th class="text-center">Qty</th>
            <th class="text-center">UM</th>
            <th class="text-center">Exp. Rev. No.</th>
            <th class="text-center">Received Date</th>
            <th class="text-center">Expired Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tmp_trace_arr as $key => $value):
            if (strtotime(date('Y-m-d')) >= strtotime($value->EXPIRED_DATE)) {
                $text_class = 'bg-red';
            } elseif (strtotime(date('Y-m-d')) > strtotime($value->EXPIRED_DATE . ' -1 month')) {
                $text_class = 'bg-yellow';
            } else {
                $text_class = 'bg-green';
            }
            ?>
            <tr class="text_class">
                <td class="text-center">
                    <?php
                    $options = [
                        'title' => 'View Log Data',
                        'class' => 'popupModal',
                    ];
                    $url = ['expiration-get-log', 'SERIAL_NO' => $value->SERIAL_NO];
                    $tmp_count = app\models\TraceItemDtrLog::find()->where(['SERIAL_NO' => $value->SERIAL_NO])->count();
                    if ($tmp_count == 0) {
                        echo '<span class="glyphicon glyphicon-list-alt disabled-link"></span>';
                    } else {
                        echo Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, $options);
                    }
                    
                    ?>
                </td>
                <td class="text-center"><?= $value->SERIAL_NO; ?></td>
                <td class="text-center"><?= $value->ITEM; ?></td>
                <td class=""><?= $value->ITEM_DESC; ?></td>
                <td class="text-center"><?= $value->NILAI_INVENTORY; ?></td>
                <td class="text-center"><?= $value->UM; ?></td>
                <td class="text-center"><?= $value->EXPIRED_REVISION_NO; ?></td>
                <td class="text-center"><?= date('Y-m-d', strtotime($value->RECEIVED_DATE)); ?></td>
                <td class="text-center <?= $text_class; ?>"><?= date('Y-m-d', strtotime($value->EXPIRED_DATE)); ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>