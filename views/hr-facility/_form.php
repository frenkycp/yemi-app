<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\HrFacility $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="hr-facility-form">

    <?php $form = ActiveForm::begin([
    'id' => 'HrFacility',
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
            

<!-- attribute period -->
			<?= $form->field($model, 'period')->textInput() ?>

<!-- attribute nik -->
			<?= $form->field($model, 'nik')->textInput() ?>

<!-- attribute emp_name -->
			<?= $form->field($model, 'emp_name')->textInput() ?>

<!-- attribute cc_id -->
			<?= $form->field($model, 'cc_id')->textInput() ?>

<!-- attribute dept -->
			<?= $form->field($model, 'dept')->textInput() ?>

<!-- attribute section -->
			<?= $form->field($model, 'section')->textInput() ?>

<!-- attribute facility_name -->
			<?= $form->field($model, 'facility_name')->textInput() ?>

<!-- attribute remark -->
			<?= $form->field($model, 'remark')->textInput() ?>

<!-- attribute response -->
			<?= $form->field($model, 'response')->textInput() ?>

<!-- attribute responder_id -->
			<?= $form->field($model, 'responder_id')->textInput() ?>

<!-- attribute responder_name -->
			<?= $form->field($model, 'responder_name')->textInput() ?>

<!-- attribute input_datetime -->
			<?= $form->field($model, 'input_datetime')->textInput() ?>

<!-- attribute response_datetime -->
			<?= $form->field($model, 'response_datetime')->textInput() ?>

<!-- attribute remark_category -->
			<?= $form->field($model, 'remark_category')->textInput() ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'HrFacility'),
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

