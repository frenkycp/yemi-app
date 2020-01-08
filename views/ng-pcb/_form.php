<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\typeahead\TypeaheadBasic;

/**
* @var yii\web\View $this
* @var app\models\KlinikInput $model
* @var yii\widgets\ActiveForm $form
*/

$ng_found_dropdown = \Yii::$app->params['ng_found_dropdown'];
ksort($ng_found_dropdown);

$ng_pcb_cause_dropdown = \Yii::$app->params['ng_pcb_cause_dropdown'];

$ng_pcb_process_dropdown = \Yii::$app->params['ng_pcb_process_dropdown'];
ksort($ng_pcb_process_dropdown);

$ng_pcb_repair_dropdown = \Yii::$app->params['ng_pcb_repair_dropdown'];
ksort($ng_pcb_repair_dropdown);

$ng_pcb_cause_category_dropdown = \Yii::$app->params['ng_pcb_cause_category_dropdown'];
ksort($ng_pcb_cause_category_dropdown);

$tmp_part = app\models\SapItemTbl::find()
->select(['material', 'material_description'])
->where([
    'valcl' => '9040'
])
->asArray()->all();
$part_arr = [];
foreach ($tmp_part as $key => $value) {
    $part_arr[] = $value['material'] . ' | ' . $value['material_description'];
}

$this->registerCss("
    .form-group {
        margin-bottom: 0px;
    }
");

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
                <div class="col-md-6">
                    <?= $form->field($model, 'gmc_no')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\SernoMaster::find()->select([
                            'gmc', 'model', 'color', 'dest'
                        ])
                        ->all(), 'gmc', 'fullDescription'),
                        'options' => [
                            'placeholder' => 'Select Model ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>

                    <?= $form->field($model, 'pcb_name')->textInput(['onkeyup' => 'this.value=this.value.toUpperCase()']); ?>

                    <?= $form->field($model, 'pcb_ng_found')->dropDownList($ng_found_dropdown, [
                        'prompt' => 'Choose...'
                    ])->label('NG Found'); ?>

                    <?= $form->field($model, 'pcb_side')->dropDownList([
                        'A' => 'A',
                        'B' => 'B',
                    ], [
                        'prompt' => 'Choose...'
                    ]); ?>

                    <?= $form->field($model, 'ng_qty')->textInput(['type' => 'number']); ?>

                    <?= $form->field($model, 'pcb_problem')->textArea(['style' => 'resize: vertical;', 'onkeyup' => 'this.value=this.value.toUpperCase()']); ?>

                    <?= $form->field($model, 'ng_root_cause')->dropDownList($ng_pcb_cause_dropdown, [
                        'prompt' => 'Choose...'
                    ]); ?>

                    <?= $form->field($model, 'pcb_occu')->textInput(['onkeyup' => 'this.value=this.value.toUpperCase()']); ?>

                    <?= $form->field($model, 'pcb_process')->dropDownList($ng_pcb_process_dropdown, [
                        'prompt' => 'Choose...'
                    ])->label('Process'); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'line')->dropDownList([
                        'Line 1' => 'Line 1',
                        'Line 2' => 'Line 2',
                        'Line 3' => 'Line 3',
                        'Line 4' => 'Line 4',
                    ], [
                        'prompt' => 'Choose...'
                    ]); ?>

                    <?= $form->field($model, 'pcb_part_section')->dropDownList([
                        'SMT' => 'SMT',
                        'AUTO INSERT' => 'AUTO INSERT',
                        'MANUAL INSERT' => 'MANUAL INSERT',
                    ], [
                        'prompt' => 'Choose...'
                    ]); ?>

                    <?= $form->field($model, 'part_desc')->widget(TypeaheadBasic::classname(), [
                        'data' => $part_arr,
                        //'options' => ['placeholder' => 'Input GMC'],
                        'pluginOptions' => ['highlight'=>true],
                    ])->label('Part Name'); ?>

                    <?= $form->field($model, 'ng_location')->textInput(['onkeyup' => 'this.value=this.value.toUpperCase()'])->label('Location'); ?>

                    <?= $form->field($model, 'created_by_name')->textInput(['readonly' => true])->label('PIC'); ?>

                    <?= $form->field($model, 'detected_by_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                            'NIK_SUN_FISH', 'NAMA_KARYAWAN'
                        ])
                        ->where([
                            'AKTIF' => 'Y'
                        ])
                        ->all(), 'NIK_SUN_FISH', 'nikSunFishNama'),
                        'options' => [
                            'placeholder' => 'Choose...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('DETECTED'); ?>

                    <?= $form->field($model, 'pcb_repair')->dropDownList($ng_pcb_repair_dropdown, [
                        'prompt' => 'Choose...'
                    ])->label('Repair'); ?>

                    <?= $form->field($model, 'ng_cause_category')->dropDownList($ng_pcb_cause_category_dropdown, [
                        'prompt' => 'Choose...',
                        'onchange' => '
                            var id_emp = $("#emp_id").select2("data")[0].id;
                            if($(this).val() == "MAN"){
                                if(id_emp == ""){
                                    $("#btn-submit").attr("disabled", true);
                                }
                            } else {
                                $("#btn-submit").removeAttr("disabled");
                            }
                            
                            $("#emp_id").val("").trigger("change");
                        ',
                    ])->label('Root Cause Category'); ?>

                    <?= $form->field($model, 'emp_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                            'NIK_SUN_FISH', 'NAMA_KARYAWAN'
                        ])
                        ->where([
                            'AKTIF' => 'Y'
                        ])
                        ->all(), 'NIK_SUN_FISH', 'nikSunFishNama'),
                        'options' => [
                            'placeholder' => '- SELECT -',
                            'id' => 'emp_id',
                            'onchange' => '
                                var id_emp = $("#emp_id").select2("data")[0].id;
                                if(id_emp == ""){
                                    $("#btn-submit").attr("disabled", true);
                                } else {
                                    $("#btn-submit").removeAttr("disabled");
                                }
                            ',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('PIC (NG)'); ?>
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

