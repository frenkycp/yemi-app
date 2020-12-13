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
    'page_title' => 'Employees Temperature Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Employees Temperature Monitoring',
    'breadcrumbs_title' => 'Employees Temperature Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');


$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.5em; text-align: center;}
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

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 18px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        //padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
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
    .side-title {
        font-size: 20px;
        color: white;
        letter-spacing: 2px;
        font-weight : bold;
    }
    //tbody > tr > td { background: #33383d;}
    .summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

$script = <<< JS
    $(function() {
        $('#belum_cek_1').click(function () {
            $('#modal_1').modal('show');
        });
        $('#belum_cek_2').click(function () {
            $('#modal_2').modal('show');
        });
        $('#belum_cek_3').click(function () {
            $('#modal_3').modal('show');
        });
    });
JS;

$this->registerJs($script);


/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['temperature-daily']),
]); ?>

<div class="row" style="width: 200px; padding-top: 10px;">
    <div class="col-md-12">
        <?= $form->field($model, 'post_date')->widget(DatePicker::classname(), [
            //'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'removeButton' => false,
            'options' => [
                'placeholder' => 'Enter date ...',
                'class' => 'form-control text-center',
                'onchange'=>'this.form.submit()',
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label(false); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="row">
    <div class="col-sm-4">
        <div class="side-title"><i class="fa fa-caret-right"></i> Cek Hari Ini</div>
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th class="text-center">Shift</th>
                    <th class="text-center">Sudah Cek</th>
                    <th class="text-center">Belum Cek</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shift_summary_arr as $shift => $value): ?>
                    <tr>
                        <td class="text-center"><?= $shift; ?></td>
                        <td class="text-center"><?= number_format($value['total_check']); ?></td>
                        <td class="text-center"><span id="belum_cek_<?= $shift; ?>"><?= number_format($value['total_no_check']); ?></span></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="side-title"><i class="fa fa-caret-right"></i> Suhu >= 37.5&deg;C</div>
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th class="text-center">NIK</th>
                    <th class="">Nama</th>
                    <th class="text-center">Suhu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($tmp_data_suspect) > 0) {
                    ?>
                    <?php foreach ($tmp_data_suspect as $value): ?>
                        <tr>
                            <td class="text-center"><?= $value['nik']; ?></td>
                            <td class=""><?= $value['name']; ?></td>
                            <td class="text-center"><?= $value['temperature']; ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php } else {
                    echo '<tr>
                        <td colspan="3">Tidak ada suspect...</td>
                    </tr>';
                }
                ?>
                
            </tbody>
        </table>

    </div>
    <div class="col-sm-8">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/dark-unica',
                //'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 600,
                    'style' => [
                        'fontFamily' => 'sans-serif'
                    ],
                    'backgroundColor' => 'black'
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => null
                ],
                'subtitle' => [
                    'text' => null
                ],
                'xAxis' => [
                    'categories' => $categories,
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Total Person(s)'
                    ],
                ],
                'plotOptions' => [
                    'column' => [
                        'dataLabels' => [
                            'enabled' => true,
                        ]
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]
                    ],
                ],
                'series' => $data_chart
            ],
        ]);
        ?>
    </div>
</div>

<?php foreach ($tmp_belum_check as $shift_val => $data_arr): 
    yii\bootstrap\Modal::begin([
        'id' =>'modal_' . $shift_val,
        'header' => '<h3>Belum Cek (Shift ' . $shift_val . ')</h3>',
        'size' => 'modal-lg',
    ]);
    ?>

    <div id="modalContent<?= $key; ?>">
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">NIK</th>
                    <th class="">Name</th>
                    <th class="">Absensi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                foreach ($data_arr as $key => $value): 
                    $no++;
                    ?>
                    <tr>
                        <td class="text-center"><?= $no; ?></td>
                        <td class="text-center"><?= $value['nik']; ?></td>
                        <td class=""><?= $value['name']; ?></td>
                        <td class=""><?= $value['attendance']; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
    </div>

    <?php
    yii\bootstrap\Modal::end();
    ?>
    
<?php endforeach ?>

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>