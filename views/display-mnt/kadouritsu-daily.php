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
    'page_title' => 'OEE RECORDING',
    'tab_title' => 'OEE RECORDING',
    'breadcrumbs_title' => 'OEE RECORDING'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    //.form-control, .control-label {background-color: #FFF; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    //body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    //body, .content-wrapper {background-color: #FFF;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    //.active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

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
    //li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

$this->registerJs("
    function change(){
        $('#machine-id').prop('disabled', true);
        var selectValue = $('#loc-id').val();            
        //$('#machine-id').empty();
        $.post( '" . \Yii::$app->urlManager->createUrl('display-mnt/kadouritsu-get-machine?loc_id=') . "'+selectValue,
            function(data){
                $('#machine-id').html(data);
                $('#machine-id').prop('disabled', false);
            }
        );

    }
    $(document).ready(function() {
        //$('#machine-id').prop('disabled', true);
        $('#loc-id').change(function(){
            change();
        });
        //$('#loc-id').trigger('change');
    });
");

// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_kadouritsu2);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['kadouritsu-daily']),
]); ?>

<div class="row" style="">
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
        <?= $form->field($model, 'location')->dropDownList($loc_dropdown, [
            'id' => 'loc-id',
            'prompt' => '-Select Location-'
        ]); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'machine')->dropDownList($machine_dropdown, [
            'id' => 'machine-id',
            //'disabled' => true,
        ]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Kadouritsu</a></li>
        <li><a href="#tab_2" data-toggle="tab">Sougyouritsu</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <?=
            Highcharts::widget([
                'scripts' => [
                    //'themes/dark-unica',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 300,
                        'zoomType' => 'x'
                    ],
                    /*'time' => [
                        'useUTC' => false
                    ],*/
                    'title' => [
                        'text' => null
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                    ],
                    'yAxis' => [
                        'title' => [
                            'enabled' => false
                        ],
                        //'allowDecimals' => false,
                        'max' => 100,
                        'min' => 0,
                        //'tickInterval' => 20
                    ],
                    'legend' => [
                        'enabled' => false
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'exporting' => [
                        'enabled' => false
                    ],
                    'series' => $chart_kadouritsu,
                ],
            ]);
            ?>
        </div>
        <div class="tab-pane" id="tab_2">
            <?=
            Highcharts::widget([
                'scripts' => [
                    //'themes/dark-unica',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 300,
                        'zoomType' => 'x'
                    ],
                    /*'time' => [
                        'useUTC' => false
                    ],*/
                    'title' => [
                        'text' => null
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                    ],
                    'yAxis' => [
                        'title' => [
                            'enabled' => false
                        ],
                        //'allowDecimals' => false,
                        'max' => 100,
                        'min' => 0,
                        //'tickInterval' => 20
                    ],
                    'legend' => [
                        'enabled' => false
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'exporting' => [
                        'enabled' => false
                    ],
                    'series' => $chart_sougyouritsu,
                ],
            ]);
            ?>
        </div>
    </div>
</div>

<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="">Machine</th>
            <th class="text-center">Process Time</th>
            <th class="text-center">Setup Time</th>
            <th class="text-center">Trouble</th>
            <th class="text-center">Idle</th>
            <th class="text-center">Off</th>
            <th class="text-center">Kadouritsu</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tmp_data_machine as $machine_id => $data_val):
            $tmp_penyebut = $data_val['hijau'] + $data_val['biru'] + $data_val['merah'];
            $tmp_kadouritsu = 0;
            if ($tmp_penyebut > 0) {
                $tmp_kadouritsu = round($data_val['hijau'] / $tmp_penyebut * 100, 2);
            }
            ?>
            <tr>
                <td class=""><?= $data_val['name']; ?></td>
                <td class="text-center bg-green"><?= number_format($data_val['hijau']); ?></td>
                <td class="text-center bg-teal"><?= number_format($data_val['biru']); ?></td>
                <td class="text-center bg-red"><?= number_format($data_val['merah']); ?></td>
                <td class="text-center bg-yellow"><?= number_format($data_val['kuning']); ?></td>
                <td class="text-center bg-black"><?= number_format($data_val['putih']); ?></td>
                <td class="text-center"><?= ($tmp_kadouritsu); ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>