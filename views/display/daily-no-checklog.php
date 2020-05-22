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
    'page_title' => 'No Checklog Summary <span class="japanesse light-green"></span>',
    'tab_title' => 'No Checklog Summary',
    'breadcrumbs_title' => 'No Checklog Summary'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.4em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

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
        //font-size: 4em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 100px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}
");

/*$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );*/
$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#nolog-tbl').DataTable({
        'pageLength': 25,
        'order': [[ 0, 'asc' ], [ 2, 'asc' ]]
    });
});");

$tmp_section_A = $tmp_section_B = $tmp_section_O = [];

/*echo '<pre>';
print_r($data_nolog);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['daily-no-checklog']),
]); ?>

<div class="" style="margin: auto; width: 100px;">
    <?= $form->field($model, 'post_date')->widget(DatePicker::classname(), [
        'type' => DatePicker::TYPE_INPUT,
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

<?php ActiveForm::end(); ?>

<div style="width: 60%; margin: auto;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-center">
                TOTAL
            </h3>
        </div>
        <div class="panel-body bg-black text-center">
            <span class="total-nolog">
                <?= number_format($total); ?>
            </span>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title">
                    GROUP A ( <?= count($data_nolog['A']); ?> )
                </h3>
            </div>
            <div class="panel-body bg-black">
                <?php
                if (count($data_nolog['A']) > 0) { ?>
                    <?php foreach ($data_nolog['A'] as $value): 
                        $tmp_section_A[$value['section']][] = [
                            'nik' => $value['nik'],
                            'name' => $value['name']
                        ];
                        ksort($tmp_section_A);
                        ?>
                        
                    <?php endforeach ?>
                <?php }
                ?>
                
                <div class="box-group" id="accordion-a">
                    <?php
                    $no = 0;
                    ?>
                    <?php foreach ($tmp_section_A as $key => $emp_arr): 
                        $no++;
                        ?>
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion-a" href="#collapse-a<?= $no; ?>" aria-expanded="false" class="collapsed">
                                    <?= strtoupper($key); ?> (<?= count($emp_arr); ?>)
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-a<?= $no; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="box-body bg-black">
                                    <ol>
                                        <?php foreach ($emp_arr as $emp): ?>
                                            <li>
                                                <?= strtoupper($emp['name']); ?> (<?= $emp['nik']; ?>)
                                            </li>
                                        <?php endforeach ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title">
                    GROUP B ( <?= count($data_nolog['B']); ?> )
                </h3>
            </div>
            <div class="panel-body bg-black">
                <?php
                if (count($data_nolog['B']) > 0) { ?>
                    <?php foreach ($data_nolog['B'] as $value): 
                        $tmp_section_B[$value['section']][] = [
                            'nik' => $value['nik'],
                            'name' => $value['name']
                        ];
                        ksort($tmp_section_B);
                        ?>
                        
                    <?php endforeach ?>
                <?php }
                ?>
                
                <div class="box-group" id="accordion-b">
                    <?php
                    $no = 0;
                    ?>
                    <?php foreach ($tmp_section_B as $key => $emp_arr): 
                        $no++;
                        ?>
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion-b" href="#collapse-b<?= $no; ?>" aria-expanded="false" class="collapsed">
                                    <?= strtoupper($key); ?> (<?= count($emp_arr); ?>)
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-b<?= $no; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="box-body bg-black">
                                    <ol>
                                        <?php foreach ($emp_arr as $emp): ?>
                                            <li>
                                                <?= strtoupper($emp['name']); ?> (<?= $emp['nik']; ?>)
                                            </li>
                                        <?php endforeach ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title">
                    NO SET GROUP ( <?= count($data_nolog['O']); ?> )
                </h3>
            </div>
            <div class="panel-body bg-black">
                <?php
                if (count($data_nolog['O']) > 0) { ?>
                    <?php foreach ($data_nolog['O'] as $value): 
                        $tmp_section_O[$value['section']][] = [
                            'nik' => $value['nik'],
                            'name' => $value['name']
                        ];
                        ksort($tmp_section_O);
                        ?>
                        
                    <?php endforeach ?>
                <?php }
                ?>
                
                <div class="box-group" id="accordion-o">
                    <?php
                    $no = 0;
                    ?>
                    <?php foreach ($tmp_section_O as $key => $emp_arr): 
                        $no++;
                        ?>
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion-o" href="#collapse-o<?= $no; ?>" aria-expanded="false" class="collapsed">
                                    <?= strtoupper($key); ?> (<?= count($emp_arr); ?>)
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse-o<?= $no; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="box-body bg-black">
                                    <ol>
                                        <?php foreach ($emp_arr as $emp): ?>
                                            <li>
                                                <?= strtoupper($emp['name']); ?> (<?= $emp['nik']; ?>)
                                            </li>
                                        <?php endforeach ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="width: 50%; margin: auto; display: none;">
    <div class="panel panel-primary">
        <div class="panel-body bg-black">
            <table class="table" id="nolog-tbl">
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Group</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_nolog as $key => $value): 
                        if ($key == 'A') {
                            $group_name = 'GROUP_A';
                        } elseif ($key == 'B') {
                            $group_name = 'GROUP_B';
                        } else {
                            $group_name = 'OTHERS';
                        }
                        ?>
                        <?php foreach ($value as $key2 => $value2): ?>
                            <tr>
                                <td><?= $value2['section']; ?></td>
                                <td><?= $value2['nik']; ?></td>
                                <td><?= $value2['name']; ?></td>
                                <td><?= $group_name; ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>