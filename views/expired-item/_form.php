<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\TraceItemDtr $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="trace-item-dtr-form">

    <?php $form = ActiveForm::begin([
    'id' => 'TraceItemDtr',
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
            

<!-- attribute SERIAL_NO -->
			<?= $form->field($model, 'SERIAL_NO')->textInput(['maxlength' => true]) ?>

<!-- attribute RECEIVED_DATE -->
			<?= $form->field($model, 'RECEIVED_DATE')->textInput() ?>

<!-- attribute MANUFACTURED_DATE -->
			<?= $form->field($model, 'MANUFACTURED_DATE')->textInput() ?>

<!-- attribute EXPIRED_DATE -->
			<?= $form->field($model, 'EXPIRED_DATE')->textInput() ?>

<!-- attribute LAST_UPDATE -->
			<?= $form->field($model, 'LAST_UPDATE')->textInput() ?>

<!-- attribute EXPIRED_REVISION_NO -->
			<?= $form->field($model, 'EXPIRED_REVISION_NO')->textInput() ?>

<!-- attribute LIFE_TIME -->
			<?= $form->field($model, 'LIFE_TIME')->textInput() ?>

<!-- attribute ISI_DALAM_KEMASAN -->
			<?= $form->field($model, 'ISI_DALAM_KEMASAN')->textInput() ?>

<!-- attribute NILAI_INVENTORY -->
			<?= $form->field($model, 'NILAI_INVENTORY')->textInput() ?>

<!-- attribute STD_PRICE -->
			<?= $form->field($model, 'STD_PRICE')->textInput() ?>

<!-- attribute STD_AMT -->
			<?= $form->field($model, 'STD_AMT')->textInput() ?>

<!-- attribute SUPPLIER -->
			<?= $form->field($model, 'SUPPLIER')->textInput(['maxlength' => true]) ?>

<!-- attribute LOT_NO -->
			<?= $form->field($model, 'LOT_NO')->textInput(['maxlength' => true]) ?>

<!-- attribute SURAT_JALAN -->
			<?= $form->field($model, 'SURAT_JALAN')->textInput(['maxlength' => true]) ?>

<!-- attribute BENTUK_KEMASAN -->
			<?= $form->field($model, 'BENTUK_KEMASAN')->textInput(['maxlength' => true]) ?>

<!-- attribute USER_DESC -->
			<?= $form->field($model, 'USER_DESC')->textInput(['maxlength' => true]) ?>

<!-- attribute CATEGORY -->
			<?= $form->field($model, 'CATEGORY')->textInput(['maxlength' => true]) ?>

<!-- attribute ITEM -->
			<?= $form->field($model, 'ITEM')->textInput(['maxlength' => true]) ?>

<!-- attribute ITEM_DESC -->
			<?= $form->field($model, 'ITEM_DESC')->textInput(['maxlength' => true]) ?>

<!-- attribute SUPPLIER_DESC -->
			<?= $form->field($model, 'SUPPLIER_DESC')->textInput(['maxlength' => true]) ?>

<!-- attribute UM -->
			<?= $form->field($model, 'UM')->textInput(['maxlength' => true]) ?>

<!-- attribute USER_ID -->
			<?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

<!-- attribute AVAILABLE -->
			<?= $form->field($model, 'AVAILABLE')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'TraceItemDtr'),
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

