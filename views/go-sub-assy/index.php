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
    'page_title' => 'GO-Sub Assy <span class="japanesse text-green"></span>',
    'tab_title' => 'GO-Sub Assy',
    'breadcrumbs_title' => 'GO-Sub Assy'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];\

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 180000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";

$msg_header = '';
$msg_class = ' box-primary';
if ($driver_data['STAGE'] == 'STANDBY') {
    $msg_header = 'WAITING FOR ORDER';
    $msg_class = ' box-danger';
}

$this->registerJs("$(function() {
   $('#btn-start').click(function(e) {
     e.preventDefault();
     $('#common-modal').modal('show');
   });
});");

/*echo '<pre>';
print_r($current_data);
echo '</pre>';
echo $data['name'];*/
?>

<div class="box box-solid<?= $msg_class; ?>">
    <div class="box-header">
        <h4 class="box-title"><?= $driver_data['GOJEK_ID'] . ' - ' . $driver_data['GOJEK_DESC'] ?></h4>
        <div class="pull-right"><?= $msg_header; ?></div>
    </div>
    <div class="box-body">
        <div class="form-group">
            <label class="control-label">Current Job</label>
            <?= Html::textInput('current_job', $detail_data['id'] != null ? $detail_data['item_desc'] : '-', ['class' => 'form-control', 'disabled' => true]) ?>
        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-6">
                <?= $driver_data['STAGE'] == 'DEPARTURE' ? Html::button('START', ['class' => 'btn btn-primary disabled btn-block btn-lg']) : Html::button('START', [
                    'id' => 'btn-start',
                    'class' => 'showModalButton btn btn-primary btn-block btn-lg',
                    'title' => 'GO - Sub Assy (Start)',
                    'value' => Url::to(['start', 'GOJEK_ID' => $driver_data['GOJEK_ID'], 'GOJEK_DESC' => $driver_data['GOJEK_DESC']]),
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $driver_data['STAGE'] == 'DEPARTURE' ? Html::a('END', ['end', 'GOJEK_ID' => $driver_data['GOJEK_ID'], 'GOJEK_DESC' => $driver_data['GOJEK_DESC']], [
                    'class' => 'btn btn-primary btn-block btn-lg',
                    'data' => [
                        'confirm' => 'Are you sure to finish this job ?',
                    ],
                ]) : Html::button('END', ['class' => 'btn btn-primary disabled btn-block btn-lg']); ?>
            </div>
        </div>
    </div>
</div>