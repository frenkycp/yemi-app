<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use app\models\Karyawan;
use kartik\typeahead\Typeahead;

/**
* @var yii\web\View $this
* @var app\models\Karyawan $model
* @var yii\widgets\ActiveForm $form
*/

$tmp_data_subsection = Karyawan::find()->select('DISTINCT(SUB_SECTION)')->where('SUB_SECTION IS NOT NULL')->orderBy('SUB_SECTION')->asArray()->all();
foreach ($tmp_data_subsection as $key => $value) {
    $sub_section_arr[] = $value['SUB_SECTION'];
}
?>

<div class="karyawan-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Karyawan',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute NIK -->
			<?= $form->field($model, 'NIK')->textInput(['readonly' => true]) ?>

<!-- attribute NAMA_KARYAWAN -->
			<?= $form->field($model, 'NAMA_KARYAWAN')->textInput() ?>

<!-- attribute DEPARTEMEN -->
            <?= $form->field($model, 'DEPARTEMEN')->dropDownList(ArrayHelper::map(Karyawan::find()->select('DISTINCT(DEPARTEMEN)')->orderBy('DEPARTEMEN')->all(), 'DEPARTEMEN', 'DEPARTEMEN')) ?>

<!-- attribute SECTION -->
            <?= $form->field($model, 'SECTION')->dropDownList(ArrayHelper::map(Karyawan::find()->select('DISTINCT(SECTION)')->orderBy('SECTION')->all(), 'SECTION', 'SECTION')) ?>

<!-- attribute SUB_SECTION -->
            <?= $form->field($model, 'SUB_SECTION')->widget(Typeahead::classname(), [
                'options' => ['placeholder' => 'Input Sub-Section ...'],
                'pluginOptions' => ['highlight'=>true],
                'dataset' => [
                    [
                        'local' => $sub_section_arr,
                        'limit' => 10
                    ]
                ]
            ]); ?>

<!-- attribute JENIS_KELAMIN -->
			<?= ''; //$form->field($model, 'JENIS_KELAMIN')->hiddenInput()->label(false) ?>

<!-- attribute STATUS_PERKAWINAN -->
			<?= $form->field($model, 'STATUS_PERKAWINAN')->dropDownList(ArrayHelper::map(Karyawan::find()->select('DISTINCT(STATUS_PERKAWINAN)')->orderBy('STATUS_PERKAWINAN')->all(), 'STATUS_PERKAWINAN', 'STATUS_PERKAWINAN')) ?>

<!-- attribute ALAMAT -->
			<?= $form->field($model, 'ALAMAT')->textInput() ?>

<!-- attribute ALAMAT_SEMENTARA -->
			<?= $form->field($model, 'ALAMAT_SEMENTARA')->textInput() ?>

<!-- attribute TELP -->
			<?= $form->field($model, 'TELP') ?>

<!-- attribute NPWP -->
			<?= ''; //$form->field($model, 'NPWP')->hiddenInput()->label(false) ?>

<!-- attribute KTP -->
			<?= ''; //$form->field($model, 'KTP')->hiddenInput()->label(false) ?>

<!-- attribute BPJS_KESEHATAN -->
			<?= ''; //$form->field($model, 'BPJS_KESEHATAN')->hiddenInput()->label(false) ?>

<!-- attribute BPJS_KETENAGAKERJAAN -->
			<?= ''; //$form->field($model, 'BPJS_KETENAGAKERJAAN')->hiddenInput()->label(false) ?>

<!-- attribute STATUS_KARYAWAN -->
			<?= ''; //$form->field($model, 'STATUS_KARYAWAN')->hiddenInput()->label(false) ?>

<!-- attribute CC_ID -->
			<?= ''; //$form->field($model, 'CC_ID')->hiddenInput()->label(false) ?>

<!-- attribute JABATAN_SR -->
			<?= ''; //$form->field($model, 'JABATAN_SR')->hiddenInput()->label(false) ?>

<!-- attribute JABATAN_SR_GROUP -->
			<?= ''; //$form->field($model, 'JABATAN_SR_GROUP')->hiddenInput()->label(false) ?>

<!-- attribute GRADE -->
			<?= ''; //$form->field($model, 'GRADE')->hiddenInput()->label(false) ?>

<!-- attribute DIRECT_INDIRECT -->
			<?= ''; //$form->field($model, 'DIRECT_INDIRECT')->hiddenInput()->label(false) ?>

<!-- attribute JENIS_PEKERJAAN -->
			<?= ''; //$form->field($model, 'JENIS_PEKERJAAN')->hiddenInput()->label(false) ?>

<!-- attribute SERIKAT_PEKERJA -->
			<?= ''; //$form->field($model, 'SERIKAT_PEKERJA')->hiddenInput()->label(false) ?>

<!-- attribute ACTIVE_STAT -->
			<?= ''; //$form->field($model, 'ACTIVE_STAT')->hiddenInput()->label(false) ?>

<!-- attribute PASSWORD -->
			<?= ''; //$form->field($model, 'PASSWORD')->hiddenInput()->label(false) ?>

<!-- attribute TGL_LAHIR -->
			<?= ''; //$form->field($model, 'TGL_LAHIR')->hiddenInput()->label(false) ?>

<!-- attribute TGL_MASUK_YEMI -->
			<?= ''; //$form->field($model, 'TGL_MASUK_YEMI')->hiddenInput()->label(false) ?>

<!-- attribute K1_START -->
			<?= ''; //$form->field($model, 'K1_START')->hiddenInput()->label(false) ?>

<!-- attribute K1_END -->
			<?= ''; //$form->field($model, 'K1_END')->hiddenInput()->label(false) ?>

<!-- attribute K2_START -->
			<?= ''; //$form->field($model, 'K2_START')->hiddenInput()->label(false) ?>

<!-- attribute K2_END -->
			<?= ''; //$form->field($model, 'K2_END')->hiddenInput()->label(false) ?>

<!-- attribute SKILL -->
			<?= ''; //$form->field($model, 'SKILL')->hiddenInput()->label(false) ?>

<!-- attribute KONTRAK_KE -->
			<?= ''; //$form->field($model, 'KONTRAK_KE')->hiddenInput()->label(false) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Karyawan'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Create' : 'Save'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

