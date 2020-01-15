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

$ng_pcb_occurance_dropdown = \Yii::$app->params['ng_pcb_occurance_dropdown'];
ksort($ng_pcb_occurance_dropdown);

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

                    <?= $form->field($model, 'pcb_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\SapItemTbl::find()->select([
                            'material', 'material_description'
                        ])
                        ->where([
                            'sloc' => ['WM01', 'WM02', 'WM03']
                        ])
                        ->all(), 'fullDescription', 'fullDescription'),
                        'options' => [
                            'placeholder' => 'Choose PCB...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('PCB'); ?>

                    <?= $form->field($model, 'part_desc')->widget(TypeaheadBasic::classname(), [
                        'data' => $part_arr,
                        'options' => [
                            'onkeyup' => 'this.value=this.value.toUpperCase()',
                            'onfocusout' => 'this.value=this.value.toUpperCase()',
                            'placeholder' => 'Please type part number or name to search. Leave empty if not neccessary...',
                        ],
                        'pluginOptions' => ['highlight'=>true],
                    ]); ?>

                    <?= $form->field($model, 'pcb_side')->dropDownList([
                        'A' => 'A',
                        'B' => 'B',
                    ], [
                        'prompt' => 'Choose...'
                    ]); ?>

                    <?= $form->field($model, 'smt_group')->dropDownList([
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                    ], [
                        'prompt' => 'Choose...'
                    ]); ?>

                    <?= $form->field($model, 'smt_pic_aoi')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                            'NIK_SUN_FISH', 'NAMA_KARYAWAN'
                        ])
                        ->where([
                            'AKTIF' => 'Y',
                            'DEPARTEMEN' => 'PRODUCTION'
                        ])
                        ->all(), 'NIK_SUN_FISH', 'nikSunFishNama'),
                        'options' => [
                            'placeholder' => 'Choose...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]); ?>

                    <?= $form->field($model, 'line')->dropDownList([
                        'SMT 1' => 'SMT 1',
                        'SMT 2' => 'SMT 2',
                        'AI' => 'AI',
                    ], [
                        'prompt' => 'Choose...'
                    ]); ?>

                    <?= $form->field($model, 'smt_group_pic')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                            'NIK_SUN_FISH', 'NAMA_KARYAWAN'
                        ])
                        ->where([
                            'AKTIF' => 'Y',
                            'DEPARTEMEN' => 'PRODUCTION'
                        ])
                        ->all(), 'NIK_SUN_FISH', 'nikSunFishNama'),
                        'options' => [
                            'placeholder' => 'Choose...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]); ?>
                </div>
                <div class="col-md-6">
                    
                    <?= $form->field($model, 'ng_category_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\ProdNgCategory::find()->select([
                            'id', 'category_name', 'category_detail'
                        ])
                        ->orderBy('category_name, category_detail')
                        ->all(), 'id', 'description'),
                        'options' => [
                            'placeholder' => 'Choose...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>

                    <?= $form->field($model, 'ng_cause_category')->dropDownList($ng_pcb_cause_category_dropdown, [
                        'prompt' => 'Choose...',
                        'id' => 'cause-category-id',
                        'onchange' => '
                            
                            if($(this).val() == "MAN"){
                                $("#ng-emp-text").show();
                                var id_emp = $("#emp_id").select2("data")[0].id;
                                if(id_emp == ""){
                                    $("#btn-submit").attr("disabled", true);
                                }
                                
                            } else {
                                $("#btn-submit").removeAttr("disabled");
                                $("#ng-emp-text").hide();
                            }
                        ',
                    ])->label('Root Cause Category'); ?>

                    <div id="ng-emp-text" style="<?= !$model->isNewRecord && $model->ng_cause_category == 'MAN' ? '' : 'display: none;'; ?>">
                        <?= $form->field($model, 'emp_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                                'NIK_SUN_FISH', 'NAMA_KARYAWAN'
                            ])
                            ->where([
                                'AKTIF' => 'Y',
                                'DEPARTEMEN' => 'PRODUCTION'
                            ])
                            ->all(), 'NIK_SUN_FISH', 'nikSunFishNama'),
                            'options' => [
                                'placeholder' => '- SELECT -',
                                'id' => 'emp_id',
                                'onchange' => '
                                    var id_emp = $("#emp_id").select2("data")[0].id;
                                    var cause_id = $("#cause-category-id").val();
                                    if(id_emp == "" && cause-category-id == "MAN"){
                                        $("#btn-submit").attr("disabled", true);
                                    } else {
                                        $("#btn-submit").removeAttr("disabled");
                                    }
                                ',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label('PIC (NG) <em><span class="text-red">*Must be set if "MAN" category was selected!</span></em>'); ?>
                    </div>

                    <?= $form->field($model, 'ng_detail')->textInput(['placeholder' => 'Leave empty if not neccessary...']); ?>

                    <?= $form->field($model, 'ng_location')->textInput(['onkeyup' => 'this.value=this.value.toUpperCase()', 'onfocusout' => 'this.value=this.value.toUpperCase()']); ?>

                    <?= $form->field($model, 'ng_qty')->textInput(['type' => 'number']); ?>

                    <?= $form->field($model, 'pcb_repair')->dropDownList($ng_pcb_repair_dropdown, [
                        'prompt' => 'Choose...'
                    ]); ?>
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

