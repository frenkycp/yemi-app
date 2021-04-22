<?php

use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
use kartik\widgets\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\TouchSpin;
use app\models\HrgaDrugMaster;
use app\models\HrgaDrugInOut;
use app\models\KlinikObatLog;

/**
* @var yii\web\View $this
* @var app\models\KlinikInput $model
* @var yii\widgets\ActiveForm $form
*/

$css_string = "
    td .form-group {margin-bottom: 0px;}
    .help-block {display: none;}
";
$this->registerCss($css_string);

?>

<div class="klinik-input-form">

    <?php $form = ActiveForm::begin([
    'id' => 'KlinikInput',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    ]
    );
    ?>

    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'nik_sun_fish')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                            'NIK_SUN_FISH', 'NAMA_KARYAWAN'
                        ])
                        ->all(), 'NIK_SUN_FISH', 'nikSunfishNama'),
                        'options' => [
                            'placeholder' => 'Select NIK ...',
                            'onchange' => '
                                $("#btn-submit").attr("disabled", true);
                                $.post( "' . Yii::$app->urlManager->createUrl('clinic-data/emp-info?nik=') . '"+$(this).val(), function( data ) {
                                    var data_arr = data.split("||");
                                    $( "#txt_name" ).val(data_arr[0]);
                                    $( "#txt_dept" ).val(data_arr[1]);
                                    $( "#txt_section" ).val(data_arr[2]);
                                    $( "#txt_status_karyawan" ).val(data_arr[3]);
                                    $( "#cc_id" ).val(data_arr[4]);
                                    $("#btn-submit").removeAttr("disabled");
                                });
                            ',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                    <?= $form->field($model, 'CC_ID')->hiddenInput(['readonly' => true, 'id' => 'cc_id'])->label(false); ?>
                    <?= $form->field($model, 'nama')->hiddenInput(['readonly' => true, 'id' => 'txt_name'])->label(false); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'dept')->textInput(['readonly' => true, 'id' => 'txt_dept']); ?>
                    <?= $form->field($model, 'section')->textInput(['type' => 'hidden', 'id' => 'txt_section'])->label(false); ?>
                    <?= $form->field($model, 'status_karyawan')->textInput(['type' => 'hidden', 'id' => 'txt_status_karyawan'])->label(false); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'opsi')->dropDownList([
                        1 => 'PERIKSA',
                        2 => 'ISTIRAHAT SAKIT',
                        3 => 'LAKTASI'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'sistolik', [
                        'addon' => [
                            'prepend' => ['content'=>'<i class="fa fa-stethoscope"></i>'],
                            'append' => ['content'=>'mmHg']
                        ]
                    ])->textInput(['type' => 'number']); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'diastolik', [
                        'addon' => [
                            'prepend' => ['content'=>'<i class="fa fa-stethoscope"></i>'],
                            'append' => ['content'=>'mmHg']
                        ]
                    ])->textInput(['type' => 'number']); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'temperature', [
                        'addon' => [
                            'append' => ['content'=>'&deg;C']
                        ]
                    ])->textInput(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'anamnesa')->textInput(['maxlength' => true]); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'root_cause')->textInput(['maxlength' => true]); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'diagnosa')->textInput(['maxlength' => true]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="panel panel-primary" style="margin-bottom: 0px;">
                        <div class="panel-body no-padding">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Nama Obat</th>
                                        <th class="text-center">Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($model->isNewRecord) {
                                        for ($i = 1; $i <= 5; $i++) { ?>
                                            <tr>
                                                <td class="text-center" width="60px"><?= $i; ?></td>
                                                <td>
                                                    <?= $form->field($model, 'nama_obat[]')->widget(Select2::classname(), [
                                                        'data' => ArrayHelper::map(HrgaDrugMaster::find()->select([
                                                            'drug_master_partnumb', 'drug_master_partname'
                                                        ])->orderBy('drug_master_partname')
                                                        ->all(), 'drug_master_partnumb', 'drug_master_partname'),
                                                        'options' => [
                                                            'placeholder' => 'Pilih obat...',
                                                            'id' => 'nama-obat-' . $i,
                                                        ],
                                                        'pluginOptions' => [
                                                            'allowClear' => true
                                                        ],
                                                    ])->label(false); ?>
                                                </td>
                                                <td class="text-center" width="110px">
                                                    <?= $form->field($model, 'jumlah_obat[]')->textInput(['type' => 'number'])->label(false); ?>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else {
                                        if ($model->klinik_input_id != null) {
                                            $tmp_in_out = KlinikObatLog::find()->where(['klinik_input_pk' => $model->klinik_input_id])->all();
                                            if (count($tmp_in_out) > 0) {
                                                $i = 0;
                                                foreach ($tmp_in_out as $inout_val) { 
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td class="text-center" width="60px"><?= $i; ?></td>
                                                        <td><?= $inout_val->part_desc; ?></td>
                                                        <td class="text-center"><?= $inout_val->qty; ?></td>
                                                    </tr>
                                                <?php }
                                            }
                                        } else { ?>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td colspan="2"><?= $model->obat1; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td colspan="2"><?= $model->obat2; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td colspan="2"><?= $model->obat3; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4</td>
                                                <td colspan="2"><?= $model->obat4; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5</td>
                                                <td colspan="2"><?= $model->obat5; ?></td>
                                            </tr>
                                        <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $form->errorSummary($model); ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id' => 'btn-submit',
            'class' => 'btn btn-success'
            ]
            );
            ?>
            <?= Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

