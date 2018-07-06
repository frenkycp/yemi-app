<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\SplHdr $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="spl-hdr-form">

    <?php $form = ActiveForm::begin([
    'id' => 'SplHdr',
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
            

<!-- attribute SPL_HDR_ID -->
			<?= $form->field($model, 'SPL_HDR_ID')->textInput() ?>

<!-- attribute SPL_BARCODE -->
			<?= $form->field($model, 'SPL_BARCODE')->textInput() ?>

<!-- attribute TGL_LEMBUR -->
			<?= $form->field($model, 'TGL_LEMBUR')->textInput() ?>

<!-- attribute JENIS_LEMBUR -->
			<?= $form->field($model, 'JENIS_LEMBUR')->textInput() ?>

<!-- attribute CC_ID -->
			<?= $form->field($model, 'CC_ID')->textInput() ?>

<!-- attribute CC_GROUP -->
			<?= $form->field($model, 'CC_GROUP')->textInput() ?>

<!-- attribute CC_DESC -->
			<?= $form->field($model, 'CC_DESC')->textInput() ?>

<!-- attribute USER_ID -->
			<?= $form->field($model, 'USER_ID')->textInput() ?>

<!-- attribute USER_DESC -->
			<?= $form->field($model, 'USER_DESC')->textInput() ?>

<!-- attribute USER_DOC_RCV -->
			<?= $form->field($model, 'USER_DOC_RCV')->textInput() ?>

<!-- attribute USER_DESC_DOC_RCV -->
			<?= $form->field($model, 'USER_DESC_DOC_RCV')->textInput() ?>

<!-- attribute URAIAN_UMUM -->
			<?= $form->field($model, 'URAIAN_UMUM')->textInput() ?>

<!-- attribute STAT -->
			<?= $form->field($model, 'STAT')->textInput() ?>

<!-- attribute USER_LAST_UPDATE -->
			<?= $form->field($model, 'USER_LAST_UPDATE')->textInput() ?>

<!-- attribute DOC_RCV_DATE -->
			<?= $form->field($model, 'DOC_RCV_DATE')->textInput() ?>

<!-- attribute DOC_VALIDATION_DATE -->
			<?= $form->field($model, 'DOC_VALIDATION_DATE')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'SplHdr'),
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

