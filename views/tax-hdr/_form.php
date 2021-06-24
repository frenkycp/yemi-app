<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\TaxHdr $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="tax-hdr-form">

    <?php $form = ActiveForm::begin([
    'id' => 'TaxHdr',
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
            

<!-- attribute no_seri -->
			<?= $form->field($model, 'no_seri')->textInput(['maxlength' => true]) ?>

<!-- attribute tanggalFaktur -->
			<?= $form->field($model, 'tanggalFaktur')->textInput() ?>

<!-- attribute last_updated -->
			<?= $form->field($model, 'last_updated')->textInput() ?>

<!-- attribute jumlahDpp -->
			<?= $form->field($model, 'jumlahDpp')->textInput() ?>

<!-- attribute jumlahPpn -->
			<?= $form->field($model, 'jumlahPpn')->textInput() ?>

<!-- attribute jumlahPpnBm -->
			<?= $form->field($model, 'jumlahPpnBm')->textInput() ?>

<!-- attribute no_seri_val -->
			<?= $form->field($model, 'no_seri_val')->textInput(['maxlength' => true]) ?>

<!-- attribute kdJenisTransaksi -->
			<?= $form->field($model, 'kdJenisTransaksi')->textInput(['maxlength' => true]) ?>

<!-- attribute fgPengganti -->
			<?= $form->field($model, 'fgPengganti')->textInput(['maxlength' => true]) ?>

<!-- attribute nomorFaktur -->
			<?= $form->field($model, 'nomorFaktur')->textInput(['maxlength' => true]) ?>

<!-- attribute npwpPenjual -->
			<?= $form->field($model, 'npwpPenjual')->textInput(['maxlength' => true]) ?>

<!-- attribute namaPenjual -->
			<?= $form->field($model, 'namaPenjual')->textInput(['maxlength' => true]) ?>

<!-- attribute alamatPenjual -->
			<?= $form->field($model, 'alamatPenjual')->textInput(['maxlength' => true]) ?>

<!-- attribute npwpLawanTransaksi -->
			<?= $form->field($model, 'npwpLawanTransaksi')->textInput(['maxlength' => true]) ?>

<!-- attribute namaLawanTransaksi -->
			<?= $form->field($model, 'namaLawanTransaksi')->textInput(['maxlength' => true]) ?>

<!-- attribute alamatLawanTransaksi -->
			<?= $form->field($model, 'alamatLawanTransaksi')->textInput(['maxlength' => true]) ?>

<!-- attribute statusApproval -->
			<?= $form->field($model, 'statusApproval')->textInput(['maxlength' => true]) ?>

<!-- attribute statusFaktur -->
			<?= $form->field($model, 'statusFaktur')->textInput(['maxlength' => true]) ?>

<!-- attribute referensi -->
			<?= $form->field($model, 'referensi')->textInput(['maxlength' => true]) ?>

<!-- attribute period -->
			<?= $form->field($model, 'period')->textInput(['maxlength' => true]) ?>

<!-- attribute status_upload -->
			<?= $form->field($model, 'status_upload')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'TaxHdr'),
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

