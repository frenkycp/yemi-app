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
    'page_title' => 'VMS vs FLO <span class="japanesse light-green"></span>',
    'tab_title' => 'VMS vs FLO',
    'breadcrumbs_title' => 'VMS vs FLO'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



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

    #summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 16px;
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
    #summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: yellow;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    #summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
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
    'action' => Url::to(['vms-daily-accumulation']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->dropDownList(
            $period_dropdown,
            [
                //'prompt' => 'Choose...',
            ]
        ); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'line')->dropDownList(
            $line_dropdown,
            [
                //'prompt' => 'Choose...',
            ]
        ); ?>
    </div>
    
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<br/>
<div class="box box-primary box-solid">
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                //'themes/grid-light',
                'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'line',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'zoomType' => 'x',
                    'height' => 500
                ],
                'title' => [
                    //'text' => 'Plan Qty V.S Actual Qty (Monthly Based)'
                ],
                'subtitle' => [
                    'text' => ''
                ],
                'xAxis' => [
                    'type' => 'datetime',
                    //'categories' => $value['category'],
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Total Qty'
                    ],
                    /*[
                        'title' => [
                            'text' => 'VMS v.s FLO'
                        ],
                    ], [
                        'title' => [
                            'text' => 'BALANCE'
                        ],
                        'opposite' => true,
                    ],*/
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    'shared' => true,
                    //'xDateFormat' => '%A, %b %e %Y',
                    'valueSuffix' => ' pcs'
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'series' => [
                        'dataLabels' => [
                            'enabled' => false
                        ],
                        'lineWidth' => 1.5,
                        'marker' => [
                            'radius' => 2,
                        ],
                        /*'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]*/
                    ]
                ],
                'series' => $data
            ],
        ]);
        ?>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <?php foreach ($tmp_table['thead'] as $key => $value): ?>
                        <th class="text-center"><?= $value; ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Plan</td>
                    <?php foreach ($tmp_table['plan'] as $key => $value): ?>
                        <td class="text-center"><?= $value; ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Actual</td>
                    <?php foreach ($tmp_table['actual'] as $key => $value): ?>
                        <td class="text-center"><?= $value; ?></td>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Balance</td>
                    <?php foreach ($tmp_table['balance'] as $key => $value): 
                        if ($value < 0) {
                            echo '<td class="text-center">
                                <span class="badge bg-red">' . $value . '</span>
                            </td>';
                        } else {
                            if ($value == 0) {
                                echo '<td class="text-center">
                                    <span class="badge">' . $value . '</span>
                                </td>';
                            } else {
                                echo '<td class="text-center">
                                    <span class="badge bg-green">' . $value . '</span>
                                </td>';
                            }
                        }
                        ?>
                        
                    <?php endforeach ?>
                </tr>
                <tr>
                    <td>Balance<br/>Accumulation</td>
                    <?php foreach ($tmp_table['balance_acc'] as $key => $value): 
                        if ($value < 0) {
                            echo '<td class="text-center">
                                <span class="badge bg-red">' . $value . '</span>
                            </td>';
                        } else {
                            if ($value == 0) {
                                echo '<td class="text-center">
                                    <span class="badge">' . $value . '</span>
                                </td>';
                            } else {
                                echo '<td class="text-center">
                                    <span class="badge bg-green">' . $value . '</span>
                                </td>';
                            }
                        }
                        ?>
                        
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>