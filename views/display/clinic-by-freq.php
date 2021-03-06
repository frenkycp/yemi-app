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
    'page_title' => 'Total Kunjungan Klinik <em style="font-size: 0.6em; color: grey;">(Selain Laktasi)</em> <span class="japanesse light-green"></span>',
    'tab_title' => 'Total Kunjungan Klinik',
    'breadcrumbs_title' => 'Total Kunjungan Klinik'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .control-label {color: white;}
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
");

//$this->registerCssFile('@web/css/dataTables.jqueryui.css');
$this->registerCssFile('@web/css/dataTables.bootstrap.css');

date_default_timezone_set('Asia/Jakarta');

//$this->registerJsFile('@web/js/jquery.dataTables.js');
//$this->registerJsFile('@web/js/dataTables.jqueryui.js');

$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');


/*$script = "
    $('document').ready(function() {
        $('#clinic-tbl').DataTable({
            'order': [[ 3, 'desc' ]]
        });
    });
";
$this->registerJs($script, View::POS_HEAD );*/

?>
<div class="">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        //'layout' => 'horizontal',
        'action' => Url::to(['clinic-by-freq']),
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'fiscal')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
                    'onchange'=>'this.form.submit()'
                ]
            ); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Data</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped order-column display" id="clinic-tbl">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Department</th>
                            <th class="text-center">NIK</th>
                            <th>Nama</th>
                            <th class="text-center">Total Visits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($data as $key => $value) {
                            ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $value->dept; ?></td>
                                <td class="text-center"><?= $value->nik; ?></td>
                                <td><?= $value->nama; ?></td>
                                <td class="text-center"><?= $value->total1; ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
