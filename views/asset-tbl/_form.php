<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\AssetTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="asset-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'AssetTbl',
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
            

<!-- attribute asset_id -->
			<?= $form->field($model, 'asset_id')->textInput() ?>

<!-- attribute qr -->
			<?= $form->field($model, 'qr')->textInput() ?>

<!-- attribute ip_address -->
			<?= $form->field($model, 'ip_address')->textInput() ?>

<!-- attribute computer_name -->
			<?= $form->field($model, 'computer_name')->textInput() ?>

<!-- attribute jenis -->
			<?= $form->field($model, 'jenis')->textInput() ?>

<!-- attribute manufacture -->
			<?= $form->field($model, 'manufacture')->textInput() ?>

<!-- attribute manufacture_desc -->
			<?= $form->field($model, 'manufacture_desc')->textInput() ?>

<!-- attribute cpu_desc -->
			<?= $form->field($model, 'cpu_desc')->textInput() ?>

<!-- attribute ram_desc -->
			<?= $form->field($model, 'ram_desc')->textInput() ?>

<!-- attribute rom_desc -->
			<?= $form->field($model, 'rom_desc')->textInput() ?>

<!-- attribute os_desc -->
			<?= $form->field($model, 'os_desc')->textInput() ?>

<!-- attribute nik -->
			<?= $form->field($model, 'nik')->textInput() ?>

<!-- attribute NAMA_KARYAWAN -->
			<?= $form->field($model, 'NAMA_KARYAWAN')->textInput() ?>

<!-- attribute fixed_asst_account -->
			<?= $form->field($model, 'fixed_asst_account')->textInput() ?>

<!-- attribute network -->
			<?= $form->field($model, 'network')->textInput() ?>

<!-- attribute display -->
			<?= $form->field($model, 'display')->textInput() ?>

<!-- attribute camera -->
			<?= $form->field($model, 'camera')->textInput() ?>

<!-- attribute battery -->
			<?= $form->field($model, 'battery')->textInput() ?>

<!-- attribute note -->
			<?= $form->field($model, 'note')->textInput() ?>

<!-- attribute location -->
			<?= $form->field($model, 'location')->textInput() ?>

<!-- attribute area -->
			<?= $form->field($model, 'area')->textInput() ?>

<!-- attribute department_pic -->
			<?= $form->field($model, 'department_pic')->textInput() ?>

<!-- attribute purchase_date -->
			<?= $form->field($model, 'purchase_date')->textInput() ?>

<!-- attribute LAST_UPDATE -->
			<?= $form->field($model, 'LAST_UPDATE')->textInput() ?>

<!-- attribute report_type -->
			<?= $form->field($model, 'report_type')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'AssetTbl'),
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

