<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Production Attendance <span class="japanesse text-green"></span>',
    'tab_title' => 'Production Attendance',
    'breadcrumbs_title' => 'Production Attendance'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto; max-width: 1200px;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .bg-yellow {font-size: 2em;}
    .help-block {display: none;}
");

date_default_timezone_set('Asia/Jakarta');

/*$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );*/

/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<hr>
<?php $form = ActiveForm::begin([
    'id' => 'MrbsEntry',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
]);
?>

<div class="row">
    <div class="col-md-3">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">Location</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'child_analyst')->dropDownList(ArrayHelper::map(app\models\WipLocation::find()->orderBy('child_analyst_desc')->all(), 'child_analyst', 'child_analyst_desc'), [
                    'class' => 'form-control',
                    'onchange'=>'this.form.submit()',
                    'prompt' => '-Select Location-'
                ])->label(false); ?>
                <?= $form->field($model, 'child_analyst_desc')->hiddenInput()->label(false); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">Line</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'line')->dropDownList([
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                ], [
                    'onchange'=>'this.form.submit()'
                ])->label(false); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">Total MP</h3>
            </div>
            <div class="box-body">
                <span class="form-control"><?= $total_mp; ?></span>
            </div>
        </div>
    </div>
</div>

<?= $form->field($model, 'nik', [
    'inputOptions' => [
        'autofocus' => 'autofocus'
    ]
])->textInput(['placeholder' => 'Input NIK Here', 'class' => 'text-center form-control'])->label(false); ?>

<?php ActiveForm::end(); ?>

<br/>

<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Attendance Log</h3>
    </div>
    <div class="panel-body no-padding">
        <table class="table table-responsive table-condensed table-bordered table-striped">
            <thead>
                <tr style="font-size: 2em;">
                    <th class="text-center">NIK</th>
                    <th>Name</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Datetime</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$attendance_log) {
                    echo '<tr>
                    <td colspan="4"><em>No Attendance Data today...</em></td>
                    </tr>';
                }
                $i = 1;
                foreach ($attendance_log as $key => $attendance) {
                    $tr_class = '';

                    if ($i == 1) {
                        $tr_class = 'bg-yellow';
                    }
                    $status_class = 'text-center';
                    if ($attendance->att_type == 'I') {
                        $current_status = 'IN';
                        if ($i > 1) {
                            $status_class .= ' text-green';
                        }
                        //$status_class .= ' text-green';
                    } else {
                        $current_status = 'OUT';
                        if ($i > 1) {
                            $status_class .= ' text-red';
                        }
                        //$status_class .= ' text-red';
                    }
                    echo '<tr class="' . $tr_class . '" style="font-size: ' . $font_size . ';">
                        <td class="text-center" style="width: 110px;">' . $attendance->nik . '</td>
                        <td>' . $attendance->name . '</td>
                        <td class="' . $status_class . '" style="width: 110px;">' . $current_status . '</td>
                        <td class="text-center" style="width: 270px;">' . date('Y-m-d H:i:s', strtotime($attendance->last_update)) . '</td>
                    </tr>';
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>