<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\AbsensiTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="absensi-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'AbsensiTbl',
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
            

<!-- attribute NIK_DATE_ID -->
			<?= $form->field($model, 'NIK_DATE_ID')->textInput() ?>

<!-- attribute NO -->
			<?= $form->field($model, 'NO')->textInput() ?>

<!-- attribute NIK -->
			<?= $form->field($model, 'NIK')->textInput() ?>

<!-- attribute CC_ID -->
			<?= $form->field($model, 'CC_ID')->textInput() ?>

<!-- attribute SECTION -->
			<?= $form->field($model, 'SECTION')->textInput() ?>

<!-- attribute DIRECT_INDIRECT -->
			<?= $form->field($model, 'DIRECT_INDIRECT')->textInput() ?>

<!-- attribute NAMA_KARYAWAN -->
			<?= $form->field($model, 'NAMA_KARYAWAN')->textInput() ?>

<!-- attribute PERIOD -->
			<?= $form->field($model, 'PERIOD')->textInput() ?>

<!-- attribute NOTE -->
			<?= $form->field($model, 'NOTE')->textInput() ?>

<!-- attribute DAY_STAT -->
			<?= $form->field($model, 'DAY_STAT')->textInput() ?>

<!-- attribute CATEGORY -->
			<?= $form->field($model, 'CATEGORY')->textInput() ?>

<!-- attribute YEAR -->
			<?= $form->field($model, 'YEAR')->textInput() ?>

<!-- attribute WEEK -->
			<?= $form->field($model, 'WEEK')->textInput() ?>

<!-- attribute TOTAL_KARYAWAN -->
			<?= $form->field($model, 'TOTAL_KARYAWAN')->textInput() ?>

<!-- attribute KEHADIRAN -->
			<?= $form->field($model, 'KEHADIRAN')->textInput() ?>

<!-- attribute BONUS -->
			<?= $form->field($model, 'BONUS')->textInput() ?>

<!-- attribute DISIPLIN -->
			<?= $form->field($model, 'DISIPLIN')->textInput() ?>

<!-- attribute DATE -->
			<?= $form->field($model, 'DATE')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'AbsensiTbl'),
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

