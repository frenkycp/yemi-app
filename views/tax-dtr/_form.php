<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\TaxDtr $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="tax-dtr-form">

    <?php $form = ActiveForm::begin([
    'id' => 'TaxDtr',
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
            

<!-- attribute dtrid -->
			<?= $form->field($model, 'dtrid')->textInput(['maxlength' => true]) ?>

<!-- attribute no_seri -->
			<?= $form->field($model, 'no_seri')->textInput(['maxlength' => true]) ?>

<!-- attribute hargaSatuan -->
			<?= $form->field($model, 'hargaSatuan')->textInput() ?>

<!-- attribute jumlahBarang -->
			<?= $form->field($model, 'jumlahBarang')->textInput() ?>

<!-- attribute hargaTotal -->
			<?= $form->field($model, 'hargaTotal')->textInput() ?>

<!-- attribute diskon -->
			<?= $form->field($model, 'diskon')->textInput() ?>

<!-- attribute dpp -->
			<?= $form->field($model, 'dpp')->textInput() ?>

<!-- attribute ppn -->
			<?= $form->field($model, 'ppn')->textInput() ?>

<!-- attribute tarifPpnbm -->
			<?= $form->field($model, 'tarifPpnbm')->textInput() ?>

<!-- attribute ppnbm -->
			<?= $form->field($model, 'ppnbm')->textInput() ?>

<!-- attribute nama -->
			<?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

<!-- attribute no -->
			<?= $form->field($model, 'no')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'TaxDtr'),
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

