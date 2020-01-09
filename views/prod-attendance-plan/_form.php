<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\ProdAttendanceMpPlan $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="prod-attendance-mp-plan-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ProdAttendanceMpPlan',
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
            

<!-- attribute from_date -->
			<?= $form->field($model, 'from_date')->textInput() ?>

<!-- attribute to_date -->
			<?= $form->field($model, 'to_date')->textInput() ?>

<!-- attribute created_date -->
			<?= $form->field($model, 'created_date')->textInput() ?>

<!-- attribute last_update -->
			<?= $form->field($model, 'last_update')->textInput() ?>

<!-- attribute is_enable -->
			<?= $form->field($model, 'is_enable')->textInput() ?>

<!-- attribute child_analyst -->
			<?= $form->field($model, 'child_analyst')->textInput(['maxlength' => true]) ?>

<!-- attribute child_analyst_desc -->
			<?= $form->field($model, 'child_analyst_desc')->textInput(['maxlength' => true]) ?>

<!-- attribute nik -->
			<?= $form->field($model, 'nik')->textInput(['maxlength' => true]) ?>

<!-- attribute created_by_id -->
			<?= $form->field($model, 'created_by_id')->textInput(['maxlength' => true]) ?>

<!-- attribute updated_by_id -->
			<?= $form->field($model, 'updated_by_id')->textInput(['maxlength' => true]) ?>

<!-- attribute name -->
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'ProdAttendanceMpPlan'),
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

