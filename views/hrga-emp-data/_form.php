<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\MpInOut $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="mp-in-out-form">

    <?php $form = ActiveForm::begin([
    'id' => 'MpInOut',
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
            

<!-- attribute MP_ID -->
			<?= $form->field($model, 'MP_ID')->textInput() ?>

<!-- attribute NIK -->
			<?= $form->field($model, 'NIK')->textInput() ?>

<!-- attribute NAMA_KARYAWAN -->
			<?= $form->field($model, 'NAMA_KARYAWAN')->textInput() ?>

<!-- attribute JENIS_KELAMIN -->
			<?= $form->field($model, 'JENIS_KELAMIN')->textInput() ?>

<!-- attribute STATUS_KARYAWAN -->
			<?= $form->field($model, 'STATUS_KARYAWAN')->textInput() ?>

<!-- attribute DIRECT_INDIRECT -->
			<?= $form->field($model, 'DIRECT_INDIRECT')->textInput() ?>

<!-- attribute CC_ID -->
			<?= $form->field($model, 'CC_ID')->textInput() ?>

<!-- attribute DEPARTEMEN -->
			<?= $form->field($model, 'DEPARTEMEN')->textInput() ?>

<!-- attribute SECTION -->
			<?= $form->field($model, 'SECTION')->textInput() ?>

<!-- attribute SUB_SECTION -->
			<?= $form->field($model, 'SUB_SECTION')->textInput() ?>

<!-- attribute PERIOD -->
			<?= $form->field($model, 'PERIOD')->textInput() ?>

<!-- attribute TINGKATAN -->
			<?= $form->field($model, 'TINGKATAN')->textInput() ?>

<!-- attribute AKHIR_BULAN -->
			<?= $form->field($model, 'AKHIR_BULAN')->textInput() ?>

<!-- attribute KONTRAK_KE -->
			<?= $form->field($model, 'KONTRAK_KE')->textInput() ?>

<!-- attribute SKILL -->
			<?= $form->field($model, 'SKILL')->textInput() ?>

<!-- attribute JUMLAH -->
			<?= $form->field($model, 'JUMLAH')->textInput() ?>

<!-- attribute TANGGAL -->
			<?= $form->field($model, 'TANGGAL')->textInput() ?>

<!-- attribute KONTRAK_START -->
			<?= $form->field($model, 'KONTRAK_START')->textInput() ?>

<!-- attribute KONTRAK_END -->
			<?= $form->field($model, 'KONTRAK_END')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'MpInOut'),
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

