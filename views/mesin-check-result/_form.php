<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckResult $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="mesin-check-result-form">

    <?php $form = ActiveForm::begin([
    'id' => 'MesinCheckResult',
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
            

<!-- attribute location -->
			<?= $form->field($model, 'location')->textInput() ?>

<!-- attribute area -->
			<?= $form->field($model, 'area')->textInput() ?>

<!-- attribute mesin_id -->
			<?= $form->field($model, 'mesin_id')->textInput() ?>

<!-- attribute mesin_nama -->
			<?= $form->field($model, 'mesin_nama')->textInput() ?>

<!-- attribute mesin_no -->
			<?= $form->field($model, 'mesin_no')->textInput() ?>

<!-- attribute mesin_bagian -->
			<?= $form->field($model, 'mesin_bagian')->textInput() ?>

<!-- attribute mesin_bagian_ket -->
			<?= $form->field($model, 'mesin_bagian_ket')->textInput() ?>

<!-- attribute mesin_status -->
			<?= $form->field($model, 'mesin_status')->textInput() ?>

<!-- attribute mesin_catatan -->
			<?= $form->field($model, 'mesin_catatan')->textInput() ?>

<!-- attribute mesin_periode -->
			<?= $form->field($model, 'mesin_periode')->textInput() ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput() ?>

<!-- attribute user_desc -->
			<?= $form->field($model, 'user_desc')->textInput() ?>

<!-- attribute mesin_last_update -->
			<?= $form->field($model, 'mesin_last_update')->textInput() ?>

<!-- attribute hasil_ok -->
			<?= $form->field($model, 'hasil_ok')->textInput() ?>

<!-- attribute hasil_ng -->
			<?= $form->field($model, 'hasil_ng')->textInput() ?>

<!-- attribute total_cek -->
			<?= $form->field($model, 'total_cek')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'MesinCheckResult'),
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

